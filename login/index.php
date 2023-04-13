<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
</head>
<body>
<div>
    <div>登入</div>
    <form action="javascript:login();">
        <div>
            <select id="useEmail">
                <option value="false">手機號碼</option>
                <option value="true">Email</option>
            </select>
        </div>
        <div>
            <input type="text" id="ep" placeholder="手機號碼">
        </div>
        <div>
            <input type="password" id="password" placeholder="密碼">
        </div>
        <div>
            <input type="submit" id="login" value="登入">
        </div>
    </form>
</div>
<loader></loader>
<script>
    const isUseEmail = function() {
        if ($("#useEmail").val() == "true") {
            return true
        }

        return false
    }

    const login = function() {
        const ep = $("#ep").val()
        const password = $("#password").val()
        const useEmail = isUseEmail()

        if (!(ep && password)) {
            return alert("有欄位沒填")
        }

        $.post("login.php", {
            ep: ep,
            password: password,
            useEmail: useEmail
        }, function(response, status) {
            if (status != "success") {
                return alert("請檢察網路連線")
            }

            if (response == "wrong") {
                return alert((isUseEmail() ? "Email" : "手機號碼") + "或密碼錯誤")
            } else if (response.length != 50) {
                return alert("發生了未知的錯誤\n請聯繫客服人員\n" + response)
            }

            return alert("登入成功!")
        })
    }

    $(document).ready(function() {
        $("#useEmail").on("change", function() {
            if (isUseEmail()) {
                $("#ep").attr("type", "email")
                $("#ep").attr("placeholder", "Email")
            } else {
                $("#ep").attr("type", "text")
                $("#ep").attr("placeholder", "手機號碼")
            }
        })
    })
</script>
</body>
</html>
