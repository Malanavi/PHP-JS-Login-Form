// Getting an avatar

let avatar = null;

document
  .querySelector('input[name="avatar"]')
  .addEventListener("change", function (e) {
    avatar = e.target.files[0];
  });

// Registration

document.querySelector(".register-btn").addEventListener("click", function (e) {
  e.preventDefault();

  const inputs = document.querySelectorAll("input");
  inputs.forEach((input) => input.classList.remove("error"));

  const login = document.querySelector('input[name="login"]').value;
  const email = document.querySelector('input[name="email"]').value;
  const password = document.querySelector('input[name="password"]').value;
  const passwordConfirm = document.querySelector(
    'input[name="password_confirm"]'
  ).value;

  const formData = new FormData();
  formData.append("login", login);
  formData.append("password", password);
  formData.append("password_confirm", passwordConfirm);
  formData.append("email", email);
  formData.append("avatar", avatar);

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "vendor/signup.php");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        const data = JSON.parse(xhr.responseText);
        if (data.status) {
          document.location.href = "/login";
        } else {
          if (data.type === 1) {
            data.fields.forEach(function (field) {
              document
                .querySelector(`input[name="${field}"]`)
                .classList.add("error");
            });
          }
          document.querySelector(".msg").classList.remove("hidden");
          document.querySelector(".msg").textContent = data.message;
        }
      }
    }
  };
  xhr.send(formData);
});
