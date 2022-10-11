
let allProduct = document.querySelectorAll(".containnerProduct .product");

for (let index = 0; index < allProduct.length; index++) {

    if (index += 3) {

        if (allProduct[index].classList !== null || allProduct[index].classList !== "undefined") {

            allProduct[index].classList.add("custumMargin");

        }

    }

}

let logElements = document.querySelectorAll(".logInPage .title span");
let formLog = document.querySelectorAll(".logInPage form");


logElements.forEach(el => {

    el.addEventListener("click", function () {

        if (this.classList.contains("signUp")) {

            removeAllClass(logElements, "active");
            this.classList.add("active");
            document.querySelector(".formSignIn").classList.add("fram-hide")
            document.querySelector(".formSignUp").classList.remove("fram-hide")

        }

        else if (this.classList.contains("signIn")) {

            removeAllClass(logElements, "active");
            this.classList.add("active");
            document.querySelector(".formSignIn").classList.remove("fram-hide")
            document.querySelector(".formSignUp").classList.add("fram-hide")

        }

    })

})

let allInputsEl = document.querySelectorAll(".newProduct .nameProCon");
let nameProduct = document.querySelector(".newProduct .rightElements h5");
let desProduct = document.querySelector(".newProduct .rightElements p");
let elPrice = document.querySelector(".newProduct .price");

allInputsEl.forEach(input => {

    input.onkeyup = function () {

        if (this.firstElementChild.classList.contains("nameOfProduct")) {

            nameProduct.innerHTML = this.firstElementChild.value;

            if (this.firstElementChild.value.length > 63) {

                this.firstElementChild.setAttribute("disabled", "disabled")

            }

        } else if (this.firstElementChild.classList.contains("nameProduct")) {

            desProduct.innerHTML = this.firstElementChild.value;

            if (this.firstElementChild.value.length > 282) {

                this.firstElementChild.setAttribute("disabled", "disabled")

            }

        } else if (this.firstElementChild.classList.contains("pricePro")) {

            elPrice.innerHTML = this.firstElementChild.value + "$";

        }

    }
})
let placeImg = document.querySelector(".containnerImgSlider .placeImg img");
let addNumUpBtn = document.querySelector(".containnerImgSlider .rightBtn");
let addNumDownBtn = document.querySelector(".containnerImgSlider .leftBtn");
let allImgSrcByStr = document.querySelector(".showItem .placeImg input").value;
let allImgSrcByarr = allImgSrcByStr.split(",");

// if (allImgSrcByStr == "undefined" || allImgSrcByStr == null) {
//     console.log("ye")
// }

let startCount = 0;

function slidingImg($src) {
    "use strcit";
    placeImg.src = "../upload/" + $src;

}
slidingImg(allImgSrcByarr[startCount]);
if (startCount <= 0) {
    addNumDownBtn.style.display = "none";
}
if (startCount == (allImgSrcByarr.length) - 1) {
    addNumUpBtn.style.display = "none";
}


addNumUpBtn.addEventListener("click", function () {

    startCount = startCount + 1;
    slidingImg(allImgSrcByarr[startCount]);

    if (startCount == (allImgSrcByarr.length) - 1) {
        this.style.display = "none";
        addNumDownBtn.style.display = "block";
    }


})

addNumDownBtn.addEventListener("click", function () {

    startCount = startCount - 1
    slidingImg(allImgSrcByarr[startCount]);
    if (startCount <= 0) {
        this.style.display = "none";
        addNumUpBtn.style.display = "block";
    }

})
