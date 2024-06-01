import pandas as pd

# Read the data into a pandas DataFrame
data = pd.read_csv('data/loan.csv')

# Fill missing values in specified columns with the most frequent value
cols_to_fill_most_frequent = ['Gender', 'Married', 'Dependents', 'Education', 'Self_Employed', 'Credit_History', 'Property_Area', 'Loan_Status']
for col in cols_to_fill_most_frequent:
    data[col].fillna(data[col].mode().iloc[0], inplace=True)

# Fill missing values in specified columns with previous data
cols_to_fill_previous = ['ApplicantIncome', 'CoapplicantIncome', 'LoanAmount', 'Loan_Amount_Term']
for col in cols_to_fill_previous:
    data[col].fillna(method='ffill', inplace=True)

# Save the cleaned data to a new CSV file
data.to_csv('cleaned_data.csv', index=False)
