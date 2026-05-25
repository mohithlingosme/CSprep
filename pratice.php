// Add this to your script.js file
async function loadQuestion(q_id) {
    const response = await fetch(`get_practice.php?q_id=${q_id}`);
    const steps = await response.json();
    
    let html = "";
    steps.forEach(step => {
        html += `<div class="step">
                    <h3>Step ${step.step_number}: ${step.step_title}</h3>
                    <p>${step.step_logic}</p>
                 </div>`;
    });
    document.getElementById('solution-area').innerHTML = html;
}