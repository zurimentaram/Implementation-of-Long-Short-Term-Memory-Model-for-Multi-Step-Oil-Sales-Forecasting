import pandas as pd
import numpy as np
from sklearn.preprocessing import MinMaxScaler
import joblib 
import json
import matplotlib.pyplot as plt
import matplotlib.gridspec as gridspec
import seaborn as sns
import os

# Konfigurasi
DATA_PATH = "data/penjualan.csv"
WINDOW_SIZE = 3 

# 1. Load Data
df = pd.read_csv(DATA_PATH, encoding="utf-8-sig", sep=";")
df.columns = df.columns.str.strip()

# 1.5 DETEKSI MISSING VALUES & OUTLIER (Visual)
os.makedirs("data/plots", exist_ok=True)

fig = plt.figure(figsize=(14, 10))
fig.suptitle("Deteksi Missing Values & Outlier\nData Penjualan", 
             fontsize=14, fontweight='bold', y=0.98)

gs = gridspec.GridSpec(2, 2, figure=fig, hspace=0.45, wspace=0.35)

# --- Plot 1: Heatmap Missing Values ---
ax1 = fig.add_subplot(gs[0, 0])
missing_matrix = df.isnull().astype(int)
sns.heatmap(missing_matrix, ax=ax1, cbar=False,
            cmap=["#2ecc71", "#e74c3c"],  # hijau=ada, merah=missing
            yticklabels=False, linewidths=0.3)
ax1.set_title("Heatmap Missing Values", fontsize=11, fontweight='bold')
ax1.set_xlabel("Kolom")

# --- Plot 2: Bar Chart Jumlah Missing per Kolom ---
ax2 = fig.add_subplot(gs[0, 1])
missing_counts = df.isnull().sum()
colors = ["#e74c3c" if v > 0 else "#2ecc71" for v in missing_counts]
bars = ax2.bar(missing_counts.index, missing_counts.values, color=colors, edgecolor='white')
ax2.set_title("Jumlah Missing Values per Kolom", fontsize=11, fontweight='bold')
ax2.set_ylabel("Jumlah")
ax2.tick_params(axis='x', rotation=15)
for bar, val in zip(bars, missing_counts.values):
    ax2.text(bar.get_x() + bar.get_width()/2, bar.get_height() + 0.1,
             str(val), ha='center', va='bottom', fontsize=9, fontweight='bold')

# --- Plot 3: Boxplot Outlier ---
df_clean = df.copy()
df_clean["jumlah_penjualan"] = pd.to_numeric(df_clean["jumlah_penjualan"], errors="coerce")
df_clean = df_clean.dropna(subset=["jumlah_penjualan"])

ax3 = fig.add_subplot(gs[1, 0])
bp = ax3.boxplot(df_clean["jumlah_penjualan"], vert=True, patch_artist=True,
                 boxprops=dict(facecolor="#3498db", alpha=0.6),
                 medianprops=dict(color="#e74c3c", linewidth=2),
                 flierprops=dict(marker='o', color='#e74c3c', 
                                 markerfacecolor='#e74c3c', markersize=6))
ax3.set_title("Boxplot Outlier\njumlah_penjualan", fontsize=11, fontweight='bold')
ax3.set_ylabel("Nilai Penjualan")
ax3.set_xticks([])

# --- Plot 4: Line Chart + Highlight Outlier (IQR) ---
ax4 = fig.add_subplot(gs[1, 1])
Q1 = df_clean["jumlah_penjualan"].quantile(0.25)
Q3 = df_clean["jumlah_penjualan"].quantile(0.75)
IQR = Q3 - Q1
lower = Q1 - 1.5 * IQR
upper = Q3 + 1.5 * IQR

is_outlier = (df_clean["jumlah_penjualan"] < lower) | (df_clean["jumlah_penjualan"] > upper)
outlier_df = df_clean[is_outlier]

ax4.plot(df_clean.index, df_clean["jumlah_penjualan"],
         color="#3498db", linewidth=1.5, label="Normal")
ax4.scatter(outlier_df.index, outlier_df["jumlah_penjualan"],
            color="#e74c3c", zorder=5, s=60, label=f"Outlier ({is_outlier.sum()})")
ax4.axhline(upper, color="#e67e22", linestyle="--", linewidth=1, label=f"Batas Atas ({upper:.0f})")
ax4.axhline(lower, color="#9b59b6", linestyle="--", linewidth=1, label=f"Batas Bawah ({lower:.0f})")
ax4.set_title("Distribusi Data & Outlier (IQR)", fontsize=11, fontweight='bold')
ax4.set_xlabel("Index")
ax4.set_ylabel("Jumlah Penjualan")
ax4.legend(fontsize=8)

plt.savefig("data/plots/deteksi_missing_outlier.png", dpi=150, bbox_inches='tight')
plt.show()

# Ringkasan di terminal
print("=" * 45)
print("RINGKASAN DETEKSI")
print("=" * 45)
print(f"Total baris       : {len(df)}")
print(f"Total missing     : {df.isnull().sum().sum()}")
print(f"Jumlah outlier    : {is_outlier.sum()} data")
print(f"Batas IQR         : [{lower:.2f} - {upper:.2f}]")
print("=" * 45)

# 2. Pembersihan Data
df["periode"] = pd.to_datetime(df["periode"], errors="coerce")
df["jumlah_penjualan"] = pd.to_numeric(df["jumlah_penjualan"], errors="coerce")
df = df.dropna(subset=["periode", "jumlah_penjualan"])
df = df.sort_values("periode").reset_index(drop=True)

# 3. Scaling
series_data = df[["jumlah_penjualan"]].values
scaler = MinMaxScaler(feature_range=(0, 1))
scaled_data = scaler.fit_transform(series_data)
joblib.dump(scaler, "data/scaler.pkl")

# 4. Membuat Sequence (Sliding Window)
def create_sequences(dataset, window_size):
    X, y = [], []
    for i in range(len(dataset) - window_size):
        # Ambil data dari index i sampai i + window_size (sebagai input)
        X.append(dataset[i : i + window_size].copy()) # Cukup satu kali append
        # Ambil data di index i + window_size (sebagai target/jawaban)
        y.append(dataset[i + window_size])
    return np.array(X), np.array(y)

X, y = create_sequences(scaled_data, WINDOW_SIZE)

# 5. Simpan Hasil Preprocessing
np.save("data/X.npy", X)
np.save("data/y.npy", y)

# Metadata untuk Laravel
metadata = {
    "nama_produk": df["nama_produk"].iloc[0],
    "last_period": df["periode"].iloc[-1].strftime('%Y-%m-%d'),
    "window_size": WINDOW_SIZE
}
with open("data/metadata.json", "w") as f:
    json.dump(metadata, f)

# 6. Membuat DataFrame Hasil Normalisasi
df_hasil = df.copy()
df_hasil['penjualan_ternormalisasi'] = scaled_data
df_hasil.to_csv("data/hasil_normalisasi_lengkap.csv", index=False, sep=";")

# --- BAGIAN BARU: MEMBUAT CSV SLIDING WINDOW UNTUK TABEL LAPORAN ---
sliding_window_list = []
for i in range(len(X)):
    inputs = X[i].flatten().tolist() # Mengubah array [0.1, 0.2, 0.3] jadi list
    target = y[i][0]
    sliding_window_list.append(inputs + [target])

# Nama kolom dinamis sesuai WINDOW_SIZE
column_names = [f'Input_t-{i}' for i in range(WINDOW_SIZE, 0, -1)] + ['Target_t']
df_sliding_window = pd.DataFrame(sliding_window_list, columns=column_names)
df_sliding_window.to_csv("data/hasil_sliding_window.csv", index=False, sep=";")
# -----------------------------------------------------------------

print("--- Preprocessing Sukses ---")
print(f"Total Sampel: {len(X)}")
print(f"File 'hasil_normalisasi_lengkap.csv' dan 'hasil_sliding_window.csv' telah dibuat.")