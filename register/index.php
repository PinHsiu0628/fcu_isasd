<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
</head>
<body>
<div>
    <div>註冊</div>
    <form action="javascript:register();">
        <div>
            <input type="email" id="email" placeholder="Email">
        </div>
        <div>
            <input type="password" id="password1" placeholder="密碼">
        </div>
        <div>
            <input type="password" id="password2" placeholder="再次輸入密碼">
        </div>
        <div>
            <input type="text" id="phone" placeholder="手機號碼">
        </div>
        <div>
            <input type="submit" id="register" value="註冊">
        </div>
    </form>
</div>
<loader></loader>
<script>
    const register = function() {
        const email = $("#email").val()
        const password1 = $("#password1").val()
        const password2 = $("#password2").val()
        const phone = $("#phone").val()

        if (!(email && password1 && password2 && phone)) {
            return alert("有欄位沒填")
        }

        if (password1 !== password2) {
            return alert("兩次密碼不一致")
        }

        $.post("register.php", {
            email: email,
            password: password1,
            phone: phone
        }, function(response, status) {
            if (status != "success") {
                return alert("請檢察網路連線")
            } else if (response == "002") {
                return alert("系統忙碌中: 002\n請稍後再試")
            } else if (response == "003") {
                return alert("系統故障: 003\n請聯繫客服人員")
            } else if (response == "failed") {
                return alert("無效的手機號碼")
            } else if (response == "exist") {
                return alert("電子信箱或手機號碼已註冊")
            } else if (response.length != 50) {
                return alert("發生了未知的錯誤\n請聯繫客服人員" + response)
            }

            let showHTML = '<form id="verify" method="post" action="../verify/" style="display:none;">'
            showHTML += '<input name="token" type="hidden" value="' + response + '">'
            showHTML += '</form>'

            $("loader").html(showHTML)

            $("#verify").submit()
        })
    }

    $(document).ready(function() {

    })
</script>
</body>
</html>
