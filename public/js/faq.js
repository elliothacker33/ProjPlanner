
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.question').forEach(function (question) {
      question.addEventListener('click', function () {
        let questionId = this.id;
        toggleAnswer(questionId);
      });
    });


function toggleAnswer(questionId) {
      let answerId = "a"+questionId[1];
      let answer = document.getElementById(answerId);
      let button = document.getElementById(questionId).querySelector('button');
  
      answer.classList.toggle('open');
      button.textContent = answer.classList.contains('open') ? '-' : '+';
    }
  });
  