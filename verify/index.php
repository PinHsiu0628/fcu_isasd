<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
</head>
<body>
<?php
if (!isset($_POST["token"]) || strlen($_POST["token"]) != 50) {
    header("Location: ../");

    exit();
}
?>

<div>
    <form action="javascript:void(0);">
        <div>驗證碼</div>
        <div>
            <input type="text" id="code" placeholder="驗證碼">
        </div>
        <input type="hidden" name="token" id="token" value="<?php echo $_POST["token"] ?>">
        <div>
            <input id="submit" type="submit" value="送出">
        </div>
    </form>
</div>
<script>
    const verify = function(code, token) {
        $.post("verify.php", {
            code: code,
            token: token
        }, function(response, status) {
            try {
                response = JSON.parse(response)
            } catch (e) {
                location.href = "../"
            }

            if (response.message) {
                alert(response.message)
            }

            if (response.redirect) {
                location.href = response.redirect
            }
        })
    }

    $(document).ready(function() {
        const token = $("#token").val()

        $("#submit").on("click", function() {
            const code = $("#code").val()

            verify(code, token)
        })
    })
</script>
</body>
</html>
