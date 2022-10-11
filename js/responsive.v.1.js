
let barMenu = document.querySelector(".navBarFram .iconMenu");
let logOutPage = document.querySelector(".navBarFram .logOutPage");


function addingClassOnclick(ellClick, ellClassExist, nameClassAdd) {
    "use strict";
    ellClick.addEventListener("click", function () {
        removeClass(this.parentElement.lastElementChild, "close")
        ellClassExist.classList.add(nameClassAdd)
    })
}
addingClassOnclick(barMenu, barMenu.parentElement.lastElementChild, "open")

function removingClassOnclick(ellClick, ellClassExist, nameClassRemove) {
    "use strict";
    ellClick.addEventListener("click", function () {
        addClass(barMenu.parentElement.lastElementChild, "close")
        ellClassExist.classList.remove(nameClassRemove)
    })
}
removingClassOnclick(logOutPage, barMenu.parentElement.lastElementChild, "open")

function removeClass(ell, className) {
    "use strcit";
    ell.classList.remove(className)
}

function addClass(ell, className) {
    "use strcit";
    ell.classList.add(className)
}


function removeAllClass(ellemnts, classes) {

    "use strict";

    ellemnts.forEach(el => {

        if (el.classList.contains(classes)) {

            // console.log("this elmennt " + el + " is not contain a class " + classes);
            el.classList.remove(classes);
            // console.log()

        }

    })

}


var navBarListOfHome = document.querySelectorAll(".navBar .setting .nav");
var subNavBar = document.querySelectorAll(".subNavBar .ul ul");

function setDisBllock(ellemnts) {

    "use strict";

    ellemnts.forEach(el => {

        el.addEventListener("click", function () {

            removeAllClass(navBarListOfHome, "active")
            this.classList.add("active");
            var createStr = ".subNavBar .ul ul." + this.dataset.storage;

            removeAllClass(subNavBar, "show");
            document.querySelector(createStr).classList.add("show");
            addClass(document.querySelector(createStr), "show");
        })
    });

}

setDisBllock(navBarListOfHome)

document.querySelector(".navBarFram .categories").addEventListener("click", function () {

    "use strict";

    this.lastElementChild.classList.toggle("active")
    this.parentElement.lastElementChild.classList.toggle("active")

})

document.querySelector(".navBarFram .cities").addEventListener("click", function () {

    "use strict";

    this.lastElementChild.classList.toggle("active")
    this.parentElement.lastElementChild.classList.toggle("active")

})
