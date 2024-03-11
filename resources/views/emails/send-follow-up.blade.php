<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
    <style>
      *{
        box-sizing: border-box;
        font-family: ‘Roboto’, Helvetica, Arial, sans-serif;
      }


      .email-container {
        background-color: rgb(231, 223, 248);
        padding: 20px;
        width:min-content;
        min-width:400px;

      }

      .email-card {
        padding: 50px 20px;
        background-color: rgb(255, 255, 255);
        border-radius: 20px;
        width: 100%;
        max-width: 500px;


      }
      .image-container {
        padding: 20px;
        background-color: rgb(231, 223, 248);
        border-radius: 20px;
        width:150px;
        margin:auto;
        margin-bottom: 50px;


      }

      .image-container img {
        width:100%;
        aspect-ratio:1/1;
      }

      .email-btn-container {
          width:100%;
          margin-bottom: 50px;
       }

      .email-btn {
        background-color: #001823;
        border-radius: 10px;
        border:none;
        color: white;
        padding: 10px 50px;
        margin: auto 0px;
        width:60%;
        margin-left:20%;
        box-shadow: rgba(136, 165, 191, 0.48) 6px 2px 16px 0px, rgba(255, 255, 255, 0.8) -6px -2px 16px 0px;
      }

      a {
        text-decoration:none;
        color:white;
      }

      .message {
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 20px;
        width: 100%;
        text-align: start;
      }

      p {
        text-align: justify;
        margin-bottom: 50px;
      }

      .sender-details {
        width: 100%;
        text-align: start;
      }
    </style>
</head>
<body class="body">
    <div class="email-container">
    <div class="email-card">
    <div class="image-container"><img src="https://img.icons8.com/fluency/100/mail--v1.png" alt="mail--v1" width="100" height="100"></div>
    <div>
        {!! $contents !!}
    </div>
    </div>
    </div>
    </div>



</body>
</html>