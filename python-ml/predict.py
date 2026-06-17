import numpy as np
import pandas as pd
import subprocess
import sys
import json
from pathlib import Path
from tensorflow.keras.models import load_model
from sklearn.preprocessing import MinMaxScaler

BASE_DIR = Path(__file__).resolve().parent
DATA_PATH = BASE_DIR / "data" / "penjualan.csv"
MODEL_PATH = BASE_DIR / "models" / "model_lstm.h5"
PRED_PATH = BASE_DIR / "hasil_prediksi_multistep.csv"
PLOT_SCRIPT = BASE_DIR / "plot_forecast.py"

WINDOW_SIZE = 3
N_STEPS = 6

df = pd.read_csv(DATA_PATH, encoding="utf-8-sig", sep=";")
df.columns = df.columns.str.strip()

df["periode"] = pd.to_datetime(df["periode"], errors="coerce")
df["jumlah_penjualan"] = pd.to_numeric(df["jumlah_penjualan"], errors="coerce")
df = df.dropna(subset=["periode", "jumlah_penjualan"])
df = df.sort_values("periode").reset_index(drop=True)

values = df[["jumlah_penjualan"]].astype(float).values
scaler = MinMaxScaler(feature_range=(0, 1))
scaled_values = scaler.fit_transform(values)

model = load_model(MODEL_PATH, compile=False)

# mengambil 3 data terakhir sebagai window awal
window = scaled_values[-WINDOW_SIZE:].copy()
predictions = []
future_dates = []

last_date = df["periode"].iloc[-1]

for i in range(N_STEPS):                            
    X_input = np.array([window])                    # bentuk input (1, 3, 1)
    pred_scaled = model.predict(X_input, verbose=0) # prediksi 1 langkah
    pred = scaler.inverse_transform(pred_scaled)[0][0] # denormalisasi
    predictions.append(float(pred))

    next_date = last_date + pd.DateOffset(months=i + 1)
    future_dates.append(next_date.strftime("%Y-%m-%d"))

    # update window untuk prediksi berikutnya
    window = np.vstack([window[1:], pred_scaled])

result = pd.DataFrame({
    "periode": future_dates,
    "prediksi_penjualan": predictions
})

result.to_csv(PRED_PATH, index=False)

print("Prediksi multi-step selesai")
print(result)
subprocess.run([sys.executable, str(PLOT_SCRIPT)], check=True)