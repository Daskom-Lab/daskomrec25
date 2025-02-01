import pandas as pd
from faker import Faker
import random

# Initialize Faker
fake = Faker()

# Define possible values for 'Gems', 'Status', and 'State'
gems_options = ['No Gem'] # 'Fire Opal', 'Radiant Quartz', 'Crystal Of The Prism', 'Moonstone', 'Opal Gem']
status_options = ['Pass', 'Fail', 'Unknown']
state_options = [
                    'Administration',
                    'Coding & Writing Test',
                    'Interview',
                    'Grouping Task',
                    'Teaching Test',
                    'Upgrading'
                ]

# Generate fake data
data = []
for _ in range(50):  # Generate 50 fake records
    nim = fake.unique.random_int(min=1000000, max=9999999)
    name = fake.name()
    email = fake.email()
    major = fake.random_element(elements=['Teknik Elekto', 'Teknik Telekomunikasi', 'Teknik Sistem Energi', 'Teknik Biomedis', 'Teknik Fisika'])
    class_name = f"{random.choice(['EL', 'TT', 'TB', 'TSE', 'TF'])}-{random.randint(1, 99):02}"
    gems = random.choice(gems_options)
    status = random.choice(status_options)
    state = random.choice(state_options)
    gender = random.choice(['Male', 'Female'])

    data.append([nim, name, email, major, class_name, gems, status, state, gender])

# Create DataFrame
df = pd.DataFrame(data, columns=['NIM', 'Name', 'Email', 'Major', 'Class', 'Gems', 'Status', 'State', 'Gender'])

# Save to Excel
file_name = "test_caas.xlsx"
df.to_excel(file_name, index=False)

print(f"Test Excel file '{file_name}' has been created successfully!")

