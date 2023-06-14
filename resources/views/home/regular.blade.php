<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>deMentor - Your AI Assistant</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/styles.css" />

</head>
<body>
    
    <div id="chat_container">

    </div>

    <form>
        <textarea name="prompt" rows="1" cols="1" placeholder="Ask me anything..."></textarea>
        <button type="submit"><img src="/assets/send.svg" /></button>
    </form>


    <script src="/script.js"></script>
</body>
</html>