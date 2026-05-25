// app.js
async function loadSolution(q_id) {
    const res = await fetch(`get_practice.php?q_id=${q_id}`);
    const steps = await res.json();
    
    const modal = document.getElementById('exam-modal');
    modal.classList.remove('hidden');
    
    let html = `<h2>Exam Solver</h2>`;
    steps.forEach(s => {
        html += `
            <div class="step-card">
                <h4>Step ${s.step_number}: ${s.step_title}</h4>
                <p>${s.step_logic}</p>
                <small>Marks: ${s.marks_awarded}</small>
            </div>`;
    });
    modal.innerHTML = html;
}sss