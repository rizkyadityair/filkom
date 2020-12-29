function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

function filterFunction() {
  var input, filter, ul, li, a, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  div = document.getElementById("myDropdown");
  a = div.getElementsByTagName("a");
  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}

// Load google charts
google.charts.load('current', {
  'packages': ['corechart']
});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['Bidang', 'Jumlah'],
    ['Mahasiswa', 6],
    ['Akademik', 9],

    
   
  ]);
  var data2 = google.visualization.arrayToDataTable([
      ['Perusahaan', 'Jumlah'],
      ['Idemia', 3],
      ['Gojek', 3],
      ['Abundent', 2],
  ]);

  // Optional; add a title and set the width and height of the chart
  var options = {
    'title': 'Bidang Kerjasama',
    'width': 600,
    'height': 200
  };

  var options2 = {
      'title': 'Perusahaan',
      'width': 600,
      'height': 200
    };

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
  var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
  chart.draw(data2, options2);
}

$(function percent() {

  $(".progress").each(function percent() {

    var value = $(this).attr('data-value');
    var left = $(this).find('.progress-left .progress-bar');
    var right = $(this).find('.progress-right .progress-bar');

    if (value > 0) {
      if (value <= 50) {
        right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
      } else {
        right.css('transform', 'rotate(180deg)')
        left.css('transform', 'rotate(' + percentageToDegrees(value - 50) + 'deg)')
      }
    }

  })

  function percentageToDegrees(percentage) {

    return percentage / 100 * 360

  }

  

});

function openPage(pageName, elmnt, color) {
  // Hide all elements with class="tabcontent" by default */
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Remove the background color of all tablinks/buttons
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }

  // Show the specific tab content
  document.getElementById(pageName).style.display = "block";

  // Add the specific color to the button used to open the tab content
  elmnt.style.backgroundColor = color;
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

function filterFunction() {
  var input, filter, ul, li, a, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  div = document.getElementById("myDropdown");
  a = div.getElementsByTagName("a");
  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}


// Load google charts
google.charts.load('current', {
  'packages': ['corechart']
});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['Bidang', 'Jumlah'],
    ['Mahasiswa', 6],
    ['Akademik', 9],

    
   
  ]);
  var data2 = google.visualization.arrayToDataTable([
      ['Perusahaan', 'Jumlah'],
      ['Idemia', 3],
      ['Gojek', 3],
      ['Abundent', 2],
  ]);

  // Optional; add a title and set the width and height of the chart
  var options = {
    'title': 'Bidang Kerjasama',
    'width': 400,
    'height': 200
  };

  var options2 = {
      'title': 'Perusahaan',
      'width': 400,
      'height': 200
    };

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
  var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
  chart.draw(data2, options2);
}