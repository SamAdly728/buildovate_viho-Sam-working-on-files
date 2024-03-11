<template>
<div class="chat-container">
  <div class="bubble sent">
    <p>
        {{ props.message }}
    </p>
  </div>
</div>
</template>
<script setup>
    const props = defineProps({
        message: {
            type: String,
            default: 'No message in props'
        }
    });
</script>
<style scoped>
    /* Chat container */
.chat-container {
  display: flex;
  flex-direction: column;
  max-width: 100%;
  margin: auto;
}

/* Generic bubble styles */
.bubble {
  white-space: pre-wrap; /* Preserves whitespace and wraps text */
  padding: 10px 15px;
  border-radius: 20px;
  margin: 5px;
  max-width: 80%;
  word-wrap: break-word;
  font-family: Arial, sans-serif;
  font-size: 14px;
  line-height: 1.5;
  position: relative;
}

/* Styles for sent messages */
.sent {
  align-self: flex-end;
  background-color: #daf8cb; /* Light green */
  color: #303030; /* Dark text color for sent messages */
  border-radius: 20px 20px 0 20px;
}

.sent::after {
  content: "";
  position: absolute;
  border-width: 10px;
  border-style: solid;
  border-color: transparent transparent transparent #daf8cb;
  right: -20px;
  bottom: 0px;
}

/* Styles for received messages */
.received {
  align-self: flex-start;
  background-color: #ffffff; /* White */
  color: #303030; /* Dark text color for received messages */
  box-shadow: 0 1px 0.5px rgba(0, 0, 0, 0.13); /* Slight shadow for depth */
}

.received::after {
  content: "";
  position: absolute;
  border-width: 10px;
  border-style: solid;
  border-color: transparent #ffffff transparent transparent;
  left: -20px;
  bottom: 0px;
}

</style>