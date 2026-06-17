from pathlib import Path
import pandas as pd
import sys
import json
import matplotlib.pyplot as plt
import matplotlib.dates as mdates

BASE_DIR = Path(__file__).resolve().parent
PROJECT_DIR = BASE_DIR.parent
OUTPUT_DIR = PROJECT_DIR / "forecasting-sells" / "public" / "images"
OUTPUT_DIR.mkdir(parents=True, exist_ok=True)

output_path = OUTPUT_DIR / "grafik_aktual_vs_prediksi.png"

print("Mulai Plot")

actual = pd.DataFrame(json.loads(sys.argv[1]))
pred = pd.DataFrame(json.loads(sys.argv[2]))

actual.columns = actual.columns.str.strip()
actual["periode"] = pd.to_datetime(actual["periode"], errors="coerce")
actual["jumlah_penjualan"] = pd.to_numeric(actual["jumlah_penjualan"], errors="coerce")
actual = actual.dropna(subset=["periode", "jumlah_penjualan"])
actual = actual.sort_values("periode").reset_index(drop=True)

pred["periode"] = pd.to_datetime(pred["periode"], errors="coerce")
pred["prediksi_penjualan"] = pd.to_numeric(pred["prediksi_penjualan"], errors="coerce")
pred = pred.dropna(subset=["periode", "prediksi_penjualan"])
pred = pred.sort_values("periode").reset_index(drop=True)

fig, ax = plt.subplots(figsize=(12, 6))
ax.plot(actual["periode"], actual["jumlah_penjualan"], marker="o", linewidth=2, label="Aktual")
ax.plot(pred["periode"], pred["prediksi_penjualan"], marker="o", linestyle="--", linewidth=2, label="Prediksi")
ax.xaxis.set_major_locator(mdates.MonthLocator(interval=3))
ax.xaxis.set_major_formatter(mdates.DateFormatter("%Y-%m"))
plt.xticks(rotation=45)
ax.set_xlabel("Periode")
ax.set_ylabel("Jumlah Penjualan")
ax.set_title("Aktual vs Prediksi Penjualan")
ax.grid(True, linestyle="--", alpha=0.4)
ax.legend()
plt.tight_layout()
plt.savefig(output_path, dpi=300)
plt.close()

print(f"Grafik tersimpan di: {output_path}")