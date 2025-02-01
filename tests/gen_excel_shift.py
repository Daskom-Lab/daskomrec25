# Re-run after execution state reset

import pandas as pd
import random
from datetime import datetime, timedelta

# Generate fake shift data
num_entries = 20
shift_data = []

# Define possible shift numbers
shift_numbers = list(range(1, 11))

# Generate random dates within the next 30 days
start_date = datetime.today()

for i in range(num_entries):
    shift_no = random.choice(shift_numbers)
    date = (start_date + timedelta(days=random.randint(0, 30))).strftime("%Y-%m-%d")
    
    # Generate random start time between 08:00 and 16:00 to ensure a 2-hour shift
    start_hour = random.randint(8, 16)  
    start_minute = random.choice([0, 30])  # Either on the hour or half past
    time_start = f"{start_hour:02}:{start_minute:02}"

    # Ensure the end time is exactly 2 hours after start time
    time_end = f"{(start_hour + 2):02}:{start_minute:02}"

    kuota = random.randint(5, 20)  # Random quota between 5 and 20

    shift_data.append([i + 1, shift_no, date, time_start, time_end, kuota])

# Create DataFrame
df = pd.DataFrame(shift_data, columns=["id", "shift_no", "date", "time_start", "time_end", "kuota"])

# Save to Excel file
file_path = "test_shifts.xlsx"
df.to_excel(file_path, index=False)

