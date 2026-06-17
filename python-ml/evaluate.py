import numpy as np
import pandas as pd
import math
import os
import json
from pathlib import Path
from tensorflow.keras.models import load_model
from sklearn.preprocessing import MinMaxScaler
from sklearn.metrics import mean_absolute_error, mean_squared_error

DATA_PATH = "data/penjualan.csv"
MODEL_PATH = "models/model_lstm.h5"
WINDOW_SIZE = 3

df = pd.read_csv(DATA_PATH, encoding="utf-8-sig", sep=";")
df.columns = df.columns.str.strip()

df["periode"] = pd.to_datetime(df["periode"], errors="coerce")
df["jumlah_penjualan"] = pd.to_numeric(df["jumlah_penjualan"], errors="coerce")
df = df.dropna(subset=["periode", "jumlah_penjualan"])
df = df.sort_values("periode").reset_index(drop=True)

values = df[["jumlah_penjualan"]].astype(float).values

scaler = MinMaxScaler(feature_range=(0, 1))
scaled_values = scaler.fit_transform(values)

def create_sequences(dataset, window_size):
    X, y = [], []
    for i in range(len(dataset) - window_size):
        X.append(dataset[i:i + window_size])
        y.append(dataset[i + window_size])
    return np.array(X), np.array(y)

X, y = create_sequences(scaled_values, WINDOW_SIZE)

model = load_model(MODEL_PATH, compile=False)
pred_scaled = model.predict(X, verbose=0)

pred = scaler.inverse_transform(pred_scaled)
actual = scaler.inverse_transform(y)

mae = mean_absolute_error(actual, pred)
mse = mean_squared_error(actual, pred)
rmse = math.sqrt(mse)
mape = np.mean(np.abs((actual - pred) / actual)) * 100

result = pd.DataFrame({
    "periode": df["periode"].iloc[WINDOW_SIZE:].reset_index(drop=True),
    "aktual": actual.flatten(),
    "prediksi": pred.flatten(),
    "error": (actual - pred).flatten()
})

result.to_csv("output_evaluasi.csv", index=False)

print("Evaluasi selesai")
print(f"MAE  : {mae:.2f}")
print(f"RMSE : {rmse:.2f}")
print(f"MAPE : {mape:.2f}%")

result_json = {
    "mae": float(mae),
    "rmse": float(rmse),
    "mape": float(mape)
}

output_path = Path(r"C:\Users\Windows\Documents\Project-TA\forecasting-sells\storage\app\evaluation_result.json")
output_path.parent.mkdir(parents=True, exist_ok=True)

with open(output_path, "w", encoding="utf-8") as f:
    json.dump(result_json, f, indent=4)

print(os.getcwd())
print(output_path)
print(output_path.exists())