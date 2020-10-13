const potato = document.querySelector(".potato");

potato.addEventListener("click", () => {
  document.getElementById("potato__img").src = "imgs/talking.PNG";

  loadItems()
    .then((items) => {
      let num = Math.floor(Math.random() * items.length);
      document.getElementById("potato__sentence").innerHTML = items[num];
    })
    .catch(console.log);

  console.log("done");
});

function loadItems() {
  return fetch("data.json")
    .then((response) => response.json())
    .then((json) => json.items);
}
