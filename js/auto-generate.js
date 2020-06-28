$(document).ready(function() {
  $.getJSON('form-structure.json', function(formInfo) {
    document.title = formInfo.title;
    if (formInfo.style == 'application') {
      $('#header').append(formInfo.title);
      $('#wj-header').addClass('hide');
      $('#dashline').addClass('hide');
      $('#formsheet').addClass('app-formsheet');
    }
    else if (formInfo.style == 'survey') {
      $('#header').addClass('hide');
      $('#formsheet').addClass('wj-formsheet');
      $('#wj-title').append(formInfo.title);
      $('#wj-description').append(formInfo.description);
    }
      for (i=0;i<formInfo.qInfo.length;i++) {
        questionContent = '<div class="inner"><div class="question';
        if (formInfo.qInfo[i].required==true) {
          questionContent += ' question-required';
        }
        questionContent += '">'+(i+1)+'. '+formInfo.qInfo[i].question+'</div>';

        if (formInfo.qInfo[i].style=='default') {
          questionContent += '<input class="box" name="question'+(i+1)+'" type="'+formInfo.qInfo[i].input.type+'" placeholder="'+formInfo.qInfo[i].input.placeholder+'"';
          addRequired(i);
          questionContent += '>'; 
        }

        else if (formInfo.qInfo[i].style=='radio') {
          for (j=0;j<formInfo.qInfo[i].choice.length;j++) {
            choiceContent = '<div class="choice"><input type="radio" name="question'+(i+1)+'" value="'+formInfo.qInfo[i].choice[j]+'" id="'+formInfo.qInfo[i].choice[j]+'"';
            addRequired(i);
            choiceContent += '><label for="'+formInfo.qInfo[i].choice[j]+'">'+formInfo.qInfo[i].choice[j]+'</label></div>';
            questionContent += choiceContent;
          }
          if (formInfo.qInfo[i].other==true) {
            questionContent += '<div class="choice"><input type="radio" name="question'+(i+1)+'" value="其它" id="question'+(i+1)+'其它"><label for="question'+(i+1)+'其它">其它</label> <input class="box box-other" type="text" name="question'+(i+1)+'_other"></div>';
          }
        }

        else if (formInfo.qInfo[i].style=='checkbox') {
          for (j=0;j<formInfo.qInfo[i].choice.length;j++) {
            choiceContent = '<div class="choice"><input type="checkbox" name="question'+(i+1)+'[]" value="'+formInfo.qInfo[i].choice[j]+'" id="'+formInfo.qInfo[i].choice[j]+'"';
            addRequired(i);
            choiceContent += '><label for="'+formInfo.qInfo[i].choice[j]+'">'+formInfo.qInfo[i].choice[j]+'</label></div>';
            questionContent += choiceContent;
          }
            if (formInfo.qInfo[i].other==true) {
              questionContent += '<div class="choice"><input type="checkbox" name="question'+(i+1)+'" value="其它" id="question'+(i+1)+'其它"><label for="question'+(i+1)+'其它">其它</label> <input class="box box-other" type="text" name="question'+(i+1)+'other"></div>';
            }
        }

        else if (formInfo.qInfo[i].style=='select') {
          questionContent += '<select class="box" name="question'+(i+1)+'"><option disabled selected value> 请选择 </option>';
          for (j=0;j<formInfo.qInfo[i].choice.length;j++) {
            choiceContent = '<option value="'+formInfo.qInfo[i].choice[j]+'">'+formInfo.qInfo[i].choice[j]+'</div>';
            questionContent += choiceContent;
          }
          questionContent += '</select>';
        }

        else if (formInfo.qInfo[i].style=='textarea') {
          questionContent += '<textarea class="textarea" name="question'+(i+1)+'" rows="'+formInfo.qInfo[i].rowNum+'"';
          addRequired(i);
          questionContent += '></textarea>';
        }

        questionContent += '</div>';
        $("#form-content").append(questionContent);
      }

      function addRequired(i) {
        if (formInfo.qInfo[i].required==true) {
          style = formInfo.qInfo[i].style;
          if (style=='default' || style=='textarea') {
              questionContent += 'required';
          }
          else if (style=='radio' || style=='checkbox') {
              choiceContent += 'required';
          }
       }
      }
  });
});

