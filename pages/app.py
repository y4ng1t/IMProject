import numpy as np
import pandas as pd
from flask import Flask, request, jsonify
from flask_cors import CORS


app = Flask(__name__)
CORS(app)


class NaiveBayes:
    def fit(self, X, y):
        n_samples, n_features = X.shape
        self._classes = np.unique(y)
        n_classes = len(self._classes)

        # calculate prior for each class
        self._priors = np.zeros(n_classes, dtype=np.float64)

        for idx, c in enumerate(self._classes):
            self._priors[idx] = np.sum(y == c) / float(n_samples)

        # calculate conditional probabilities for each feature and class
        self._conditional_probs = {}
        for feature_idx in range(n_features):
            self._conditional_probs[feature_idx] = {}
            for idx, c in enumerate(self._classes):
                X_c = X[y == c, feature_idx]
                # Laplace smoothing for categorical features
                unique_categories, counts = np.unique(X_c, return_counts=True)
                # Calculate conditional probability for each category given the class
                self._conditional_probs[feature_idx][c] = {}
                for category, count in zip(unique_categories, counts):
                    self._conditional_probs[feature_idx][c][category] = (count + 1) / (len(unique_categories) + counts.sum())

    def predict(self, X):
        y_pred = [self._predict(x) for x in X]
        return np.array(y_pred)

    def _predict(self, x):
        posteriors = []

        # calculate posterior probability for each class
        for idx, c in enumerate(self._classes):
            prior = self._priors[idx]
            posterior = prior
            for feature_idx, feature_value in enumerate(x):
                conditional_prob = self._conditional_probs[feature_idx][c]
                if feature_value in conditional_prob:
                    posterior *= conditional_prob[feature_value]
                else:
                    # Laplace smoothing for unseen categories
                    posterior *= 1 / (len(conditional_prob) + 1)
            posteriors.append(posterior)

        # return class with the highest posterior
        return self._classes[np.argmax(posteriors)]

# Load data from Excel
df = pd.read_excel("Answer.xlsx")
X = df[['Umur', 'Pekerjaan', 'Penghasilan', 'Riwayat Pinjaman']].values
y = df['Ket'].values
print(df)
nb = NaiveBayes()
nb.fit(X, y)

# Define a route to handle predictions
@app.route('/predict', methods=['POST'])
def predict():
    # Check if request contains JSON data
    if request.is_json:
        data = request.get_json()
        # Extract features from the JSON data
        features = [data['umur'], data['Pekerjaan'], data['Penghasilan'], data['Riwayat_Pinjaman']]
    else:
        # If request contains form data, extract features accordingly
        features = [request.form['umur'], request.form['Pekerjaan'], request.form['Penghasilan'], request.form['Riwayat_Pinjaman']]

    # Make prediction using the trained classifier
    prediction = nb.predict([features])[0]

    # Return the prediction as JSON response
    return jsonify({'prediction': prediction})

if __name__ == '__main__':
    app.run(debug=True)
