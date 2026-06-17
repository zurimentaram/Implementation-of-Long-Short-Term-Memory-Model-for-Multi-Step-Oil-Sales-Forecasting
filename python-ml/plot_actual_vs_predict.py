import pandas as pd
import matplotlib.pyplot as plt

df = pd.read_csv('output_evaluasi.csv')

plt.figure(figsize=(14, 7))
plt.plot(df['periode'], df['aktual'], label='Aktual', color='blue', marker='o')
plt.plot(df['periode'], df['prediksi'], label='Prediksi LSTM', color='red', marker='x', linestyle='--')
plt.title('Actual vs Predicted - Model LSTM')
plt.xlabel('Periode')
plt.ylabel('Penjualan (Liter)')
plt.xticks(rotation=45)
plt.legend()
plt.grid(True)
plt.tight_layout()
plt.savefig('grafik_actual_vs_prediksi.png', dpi=300)
plt.show()