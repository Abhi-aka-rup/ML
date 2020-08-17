<!Doctype html>
<html>

<body>
    <script type='text/javascript' src='jquery-3.4.1.js'></script>
    <script type='text/javascript'>
    $(document).ready(function() {
        var lines = ""
        $.ajax({
            method: "get",
            url: "Job Satisfaction Survey (Responses).csv",
            success: function(data) {
                lines = data.split('\n')
                $.ajax({
                    method: 'post',
                    url: 'test.php',
                    data: {
                        arr: lines
                    },
                    dataType: 'json',
                    success: (data) => {
                        console.log(data[1])
                    },
                    error: (err) => {
                        console.log(err)
                    }
                })
            },
            error: function(err) {
                console.log(err)
            }
        })
    })
    </script>
</body>

</html>