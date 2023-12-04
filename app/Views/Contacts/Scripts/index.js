let deleteBtn = document.getElementsByClassName(".btn-delete");

console.log(deleteBtn);

deleteBtn.forEach((btn) => {
  btn.addEventListener("click", function () {
    fetch("index.php/?page=Contact&cd=deleteContact", {
      method: "GET",
    });
  });
});

deleteBtn.forEach((element) => {});
