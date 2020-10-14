function setDisplay() {
    var x = document.getElementsByClassName ("titles");
    var y = document.getElementById("select_button");

    for (var i = 0; i < x.length; i++) {
        if (x[i].checked === true) {
            selected_title = x[i].defaultValue;
        }
    }

    document.getElementById("title_select").hidden = false;
    document.getElementById("select_contents").innerHTML = "You selected: " + selected_title;
    y.innerHTML = '<input type="submit" value="Save" class="col-md-offset-1 btn btn-primary"/>';  
}
