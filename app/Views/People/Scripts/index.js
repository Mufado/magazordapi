function processEvent(e, type) {
  switch (type) {
    case "delete":
      deletePerson(e);
      break;
    case "edit":
      editPerson(e);
      break;
    case "search":
      searchPeople(e);
    default:
      break;
  }
}

function searchPeople(e) {
  e.preventDefault();

  fetch(
    "?page=People&cb=searchPeople&txt=" +
      encodeURIComponent(e.target.getElementsByTagName("input")[0].value)
  )
    .then(function (response) {
      return response.text();
    })
    .then(function (data) {
      document.documentElement.innerHTML = data;
    });
}

function deletePerson(e) {
  let jsonData = { id: e.target.parentNode.parentNode.getAttribute("data-id") };

  makeRequest("POST", "People/deletePerson", jsonData)
    .then(function (response) {
      window.location.replace("?page=People");
      return response.text();
    })
    .then(function (data) {
      console.log(data);
    });
}

function editPerson(e) {
  let id = e.target.parentNode.parentNode.getAttribute("data-id");
  window.location.replace("?page=People&cb=goToEditPersonPage&id=" + id);
}

function makeRequest(type, action, data = null) {
  return fetch("index.php/", {
    method: type,
    headers: {
      "Content-Type": "application/json; charset=utf-8",
      "X-Action": action,
    },
    body: type === "GET" ? null : JSON.stringify(data),
  });
}
