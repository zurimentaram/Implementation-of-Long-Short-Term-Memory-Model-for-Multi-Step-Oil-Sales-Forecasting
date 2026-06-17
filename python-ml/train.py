import numpy as np
import os
import matplotlib.pyplot as plt
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import LSTM, Dense
from sklearn.model_selection import train_test_split 

X = np.load("data/X.npy")
y = np.load("data/y.npy")

X_train, X_val, y_train, y_val = train_test_split(X, y, test_size=0.2, shuffle=False)

model = Sequential()
model.add(LSTM(50, return_sequences=True, input_shape=(X.shape[1], X.shape[2])))
model.add(LSTM(50))
model.add(Dense(1))

model.compile(optimizer="adam", loss="mse")

history = model.fit(X, y, epochs=50, batch_size=8, verbose=1)

import matplotlib.pyplot as plt

plt.figure(figsize=(12, 6))
plt.plot(history.history['loss'], label='Training Loss', color='blue')
plt.title('Grafik Loss selama Proses Pelatihan Model LSTM')
plt.xlabel('Epoch')
plt.ylabel('Loss (MSE)')
plt.legend()
plt.grid(True)
plt.savefig('grafik_loss_training.png')
plt.show()

os.makedirs("models", exist_ok=True)
model.save("models/model_lstm.h5")
model.summary()
print("Training selesai")
print("Model disimpan di models/model_lstm.h5")