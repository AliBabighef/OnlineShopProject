// start custom 
function silidingImgAnimation(ell, src) {
    "use strict";
    ell.style = "background-image: url(" + src + ");"
}

let startCounts = 0;

let itemInfoContainner = document.querySelector(".showComments .itemInfoContainner");
let btnUp = document.querySelector(".showComments .rgt");
let btnDown = document.querySelector(".showComments .lft");
let imgSrcBystrPartTwo = document.querySelector(".showComments .imgSrcBystr").value;
let imgSrcByArrPartTwo = imgSrcBystrPartTwo.split(',')

silidingImgAnimation(itemInfoContainner, "../upload/" + imgSrcByArrPartTwo[startCounts])

btnDown.addEventListener("click", function () {
    startCounts -= 1;
    silidingImgAnimation(itemInfoContainner, "../upload/" + imgSrcByArrPartTwo[startCounts])
    console.log(startCounts)
})

btnUp.addEventListener("click", function () {
    startCounts += 1;
    silidingImgAnimation(itemInfoContainner, "../upload/" + imgSrcByArrPartTwo[startCounts])
    console.log(startCounts)
})
console.log(startCounts)
// end custom 