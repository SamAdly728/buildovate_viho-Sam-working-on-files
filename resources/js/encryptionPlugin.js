import CryptoJS from 'crypto-js';

const EncryptionPlugin = {
  install(app, options) {
    if (!options || !options.secretKey) {
      console.error('EncryptionPlugin requires a secretKey option');
      return;
    }

    app.config.globalProperties.$crypto = {
      encryptData(data) {
        const encrypted = CryptoJS.AES.encrypt(data, options.secretKey);
        return encodeURIComponent(encrypted.toString()); // Cipher text
      },
      decryptData(ciphertext) {
        try {
          const bytes = CryptoJS.AES.decrypt(decodeURIComponent(ciphertext), options.secretKey);
          const originalText = bytes.toString(CryptoJS.enc.Utf8);
          return originalText;
        } catch (error) {
            console.error("Decryption failed:", error);
        }
      }
    };
  }
};

export default EncryptionPlugin;