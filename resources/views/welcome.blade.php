<!DOCTYPE html>
<head>
    <title> {{env('APP_NAME')}}Test </title>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'CSRFToken': "{{ csrf_token() }}"
            }
        });
        $(document).ready(function () {
            // Enable pusher logging - don't include this in production
            //Pusher.logToConsole = true;

            const pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
                cluster: '{{env('PUSHER_APP_CLUSTER')}}'
            });

            const channel = pusher.subscribe('my-channel');
            console.log('channel', channel)
            channel.bind('my-event', function (data) {
                //console.log('data:', data);
                console.log('data:', data.message);
                //alert(JSON.stringify(data));
                $('#result').append('<li>'+data.message+'</li>')
            });


            $("#form-chat").submit(function (e) {

                e.preventDefault();
                const messageInput = $('#message').val();
                //alert(messageInput)

                $.ajax({
                    url: "/handle-push",
                    data:{messageInput},
                    success: function (result) {
                        console.log('request send')
                    }
                });


            })

            $(".handleSend").click(function () {
                $.ajax({
                    url: "/handle-push", success: function (result) {
                        console.log('request send')
                    }
                });
            });

        });

    </script>
</head>
<body>

<form action="" id="form-chat">
    <input type="text" name="message" id="message" placeholder="Enter your message" autofocus>
</form>




<ul id="result"></ul>
</body>
