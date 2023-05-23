// Authorization

document.querySelector(".login-btn").addEventListener("click", function (e) {
  e.preventDefault();

  var inputs = document.querySelectorAll("input");
  for (var i = 0; i < inputs.length; i++) {
    inputs[i].classList.remove("error");
  }
  document.querySelector(".msg").classList.add("hidden");

  var login = document.querySelector('input[name="login"]').value;
  var password = document.querySelector('input[name="password"]').value;

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "vendor/signin.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var data = JSON.parse(xhr.responseText);

      if (data.status) {
        // Authorization successful
        ajax("/profile.php", function (profileData) {
          document.querySelector("#load").innerHTML = profileData;
          window.history.pushState({ url: "/profile" }, "", "/profile");
          
          // Display success animation block
          var animationBlock = document.querySelector(".animation-block");
          animationBlock.classList.remove("hidden");
          animationBlock.textContent = "Вы успешно авторизованы";

          // Hide animation block after 10 seconds
          setTimeout(function () {
            animationBlock.classList.add("hidden");
          }, 10000);
        });
      } else {
        if (data.type === 1) {
          data.fields.forEach(function (field) {
            document.querySelector('input[name="' + field + '"]').classList.add("error");
          });
        }

        var msgElement = document.querySelector(".msg");
        msgElement.classList.remove("hidden");
        msgElement.textContent = data.message;
      }
    }
  };
  xhr.send("login=" + login + "&password=" + password);
});

function ajax(url, callback) {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", url + "?rel=page", true);
  xhr.onload = function () {
    if (xhr.readyState === xhr.DONE && xhr.status >= 200 && xhr.status < 300) {
      if (this.response) {
        callback.call(this, this.response);
      }
    }
  };
  xhr.send();
}

var anchor = document.querySelectorAll("a[rel=page]");
[].slice.call(anchor).forEach(function (trigger) {
  trigger.addEventListener("click", function (e) {
    e.preventDefault();

    var pageUrl = this.getAttribute("href");

    ajax(pageUrl, function (data) {
      document.querySelector("#load").innerHTML = data;
      window.history.pushState({ url: pageUrl }, "", pageUrl);
    });

    if (pageUrl !== window.location) {
      window.history.pushState({ url: pageUrl }, "", pageUrl);
    }
    return false;
  });
});

window.addEventListener("popstate", function () {
  ajax(this.window.location.pathname, function (data) {
    document.querySelector("#load").innerHTML = data;
  });
});
