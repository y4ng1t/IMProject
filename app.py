import numpy as np
import pandas as pd
from flask import Flask, request, jsonify
from flask_cors import CORS
from sklearn.preprocessing import LabelEncoder
from sklearn.naive_bayes import GaussianNB
from sklearn.model_selection import StratifiedShuffleSplit
from sklearn.metrics import log_loss
import warnings
warnings.filterwarnings('ignore')

app = Flask(__name__)
CORS(app, resources={r"/predict": {"origins": "http://localhost"}})

df = pd.read_csv("data/loan.csv")
df.drop('Loan_ID', axis=1, inplace=True)
df['Credit_History'] = df['Credit_History'].astype('O')

# Handling missing values
cat_data = []
num_data = []

for i,c in enumerate(df.dtypes):
    if c == object:
        cat_data.append(df.iloc[:, i])
    else :
        num_data.append(df.iloc[:, i])

cat_data = pd.DataFrame(cat_data).transpose()
num_data = pd.DataFrame(num_data).transpose()

cat_data = cat_data.apply(lambda x:x.fillna(x.value_counts().index[0]))
num_data.fillna(method='bfill', inplace=True)
# transform the target column
target_values = {'Y': 0 , 'N' : 1}
target = cat_data['Loan_Status']
cat_data.drop('Loan_Status', axis=1, inplace=True)
target = target.map(target_values)

label_encoders = {}  # Dictionary to store label encoders for categorical variables

for i in cat_data:
    label_encoders[i] = LabelEncoder()  # Create a label encoder for each categorical variable
    cat_data[i] = label_encoders[i].fit_transform(cat_data[i])

df = pd.concat([cat_data, num_data, pd.Series(target, name='Loan_Status')], axis=1)
X = pd.concat([cat_data, num_data], axis=1)
y = target

sss = StratifiedShuffleSplit(n_splits=1, test_size=0.2, random_state=42)
for train, test in sss.split(X, y):
    X_train, X_test = X.iloc[train], X.iloc[test]
    y_train, y_test = y[train], y[test]

# Instantiate and fit Naive Bayes model
model = GaussianNB()
model.fit(X_train, y_train)

# Define a route to handle form submission
# Define a route to handle form submission
@app.route('/predict', methods=['POST'])
def predict():
    # Retrieve form data
    try:
        Gender = request.form['gender']
        Married = request.form['married']
        Dependents = request.form['Dependents']
        Property_area = request.form['Property']
        Education = request.form['Education']
        Self_Employed = request.form['selfemployed']
        ApplicantIncome = int(request.form['ApplicantIncome'])
        CoapplicantIncome = int(request.form['coApplicantIncome'])
        LoanAmount = int(request.form['LoanAmount'])
        Loan_Amount_Term = int(request.form['LoanTime'])
        Credit_History = int(request.form['CreditHistory'])
    except KeyError as e:
        return jsonify({'error': f'Missing required field: {e.args[0]}'})
    
    # Create a DataFrame with the new data
    new_data = pd.DataFrame({
        'Gender': [Gender],
        'Married': [Married],
        'Dependents': [Dependents],
        'Education': [Education],
        'Self_Employed': [Self_Employed],
        'ApplicantIncome': [ApplicantIncome],
        'CoapplicantIncome': [CoapplicantIncome],
        'LoanAmount': [LoanAmount],
        'Loan_Amount_Term': [Loan_Amount_Term],
        'Credit_History': [Credit_History],
        'Property_Area': [Property_area]
    })

    # Preprocess the new data
    for column, encoder in label_encoders.items():
        if column in new_data.columns:  # Ensure the column exists in new_data
            new_data[column] = encoder.transform(new_data[column])

    # Concatenate categorical and numerical data
    new_X = new_data[X.columns]

    # Make prediction
    prediction = model.predict(new_X)
    probability = model.predict_proba(new_X)

    # Return only prediction JSON
    return jsonify({
        'prediction': prediction[0].tolist(),
        'probability': probability[0].tolist()
    })

if __name__ == '__main__':
    app.run(debug=True)
