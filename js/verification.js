window.onload = function() {
    //alert("ok");
    render();
};

function render() {
  window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
  recaptchaVerifier.render();
}

function phoneAuth(){
  var phone = document.getElementById("phone").value;
    firebase.auth().SignInWithPhoneNumber(phone, window.recaptchaVerifier)
    .then((confirmationResult) => {
        window.confirmationResult = confirmationResult;
        codeResult = confirmationResult;
        console.log(codeResult);
        alert("Code Sent to Phone");
    }).catch(function(error){
      alert(error.message)
    });
}

function codeVerify(){
  var code = docment.getElementById("verficationCode").value;
  codeResult.confirm(code).then(function(result){
    alert("Code Verified");
    var user = result.user;
    console.log(user);
    window.location.href="home.php";
  }).catch(function(error){
    alert(error.message);
  });
}