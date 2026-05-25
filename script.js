const sqft = document.getElementById("sqft");
const sqftValue = document.getElementById("sqftValue");

sqft.oninput = function () {
    sqftValue.innerHTML = this.value + " sqft";
};

function calculateCost() {

    let area = document.getElementById("sqft").value;
    let rate = document.getElementById("quality").value;

    let total = area * rate;

    total = total.toLocaleString('en-IN');

    document.getElementById("totalCost").innerHTML =
        "₹" + total;
}

const faqQuestions =
    document.querySelectorAll(".faq-question");

faqQuestions.forEach(question => {

    question.addEventListener("click", () => {

        const answer =
            question.nextElementSibling;

        answer.style.display =
            answer.style.display === "block"
            ? "none"
            : "block";
    });

});