from flask import Flask, request, jsonify
import numpy as np
import pandas as pd
import json
import subprocess
import sys
from pathlib import Path
from tensorflow.keras.models import load_model
from sklearn.preprocessing import MinMaxScaler

app = Flask(__name__)

BASE_DIR = Path(__file__).resolve().parent
MODEL_PATH = BASE_DIR / "models" / "model_lstm.h5"
PRED_PATH = BASE_DIR / "hasil_prediksi_multistep.csv"
PLOT_SCRIPT = BASE_DIR / "plot_forecast.py"

WINDOW_SIZE = 3 
N_STEPS = 6

model = load_model(MODEL_PATH, compile=False)

def generate_multistep_forecast(df):
    df.columns = df.columns.str.strip()
    df["periode"] = pd.to_datetime(df["periode"], errors="coerce")
    df["jumlah_penjualan"] = pd.to_numeric(df["jumlah_penjualan"], errors="coerce")
    df = df.dropna(subset=["periode", "jumlah_penjualan"])
    df = df.sort_values("periode").reset_index(drop=True)

    values = df[["jumlah_penjualan"]].astype(float).values
    scaler = MinMaxScaler(feature_range=(0, 1))
    scaled_values = scaler.fit_transform(values)

    window = scaled_values[-WINDOW_SIZE:].copy()
    predictions = []
    future_dates = []

    last_date = df["periode"].iloc[-1]

    for i in range(N_STEPS):
        X_input = np.array([window])
        pred_scaled = model.predict(X_input, verbose=0)
        pred = scaler.inverse_transform(pred_scaled)[0][0]
        predictions.append(float(pred))

        next_date = last_date + pd.DateOffset(months=i + 1)
        future_dates.append(next_date.strftime("%Y-%m-%d"))

        window = np.vstack([window[1:], pred_scaled])

    return pd.DataFrame({
        "periode": future_dates,
        "prediksi_penjualan": predictions
    })

@app.post("/predict")
def predict():
    payload = request.get_json(force=True)
    penjualan = payload.get("penjualan", [])

    if not penjualan:
        return jsonify({"prediksi": [], "prediksi_terakhir": "-"}), 400

    actual_df = pd.DataFrame(penjualan)
    pred_df = generate_multistep_forecast(actual_df)

    pred_df.to_csv(PRED_PATH, index=False)

    actual_json = actual_df.to_json(orient="records", date_format="iso")
    pred_json = pred_df.to_json(orient="records", date_format="iso")

    subprocess.run(
        [sys.executable, str(PLOT_SCRIPT), actual_json, pred_json],
        check=True
    )

    prediksi_list = pred_df.to_dict(orient="records")
    return jsonify({
        "prediksi": prediksi_list,
        "prediksi_terakhir": prediksi_list[-1]["prediksi_penjualan"] if prediksi_list else "-"
    })

@app.post("/dashboard-data")
def dashboard_data():
    payload = request.get_json(force=True)
    penjualan = payload.get("penjualan", [])

    if not penjualan:
        return jsonify({
            "total_data": 0,
            "prediksi": [],
            "prediksi_terakhir": "-",
            "mae": "-",
            "rmse": "-",
            "mape": "-"
        })

    actual_df = pd.DataFrame(penjualan)
    pred_df = generate_multistep_forecast(actual_df)

    return jsonify({
        "total_data": len(penjualan),
        "prediksi": pred_df.to_dict(orient="records"),
        "prediksi_terakhir": pred_df.iloc[-1]["prediksi_penjualan"] if len(pred_df) else "-",
        "mae": "-",
        "rmse": "-",
        "mape": "-"
    })

if __name__ == "__main__":
    app.run(host="127.0.0.1", port=5000, debug=True)