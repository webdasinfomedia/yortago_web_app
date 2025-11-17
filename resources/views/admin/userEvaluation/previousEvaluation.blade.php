
  <style>
    .custom-card {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      padding: 16px;
      text-align: center;
      transition: box-shadow 0.3s ease;
    }

    .custom-card:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .custom-title {
      font-size: 16px;
      color: #888;
      margin-bottom: 16px;
      font-weight: 500;
    }

    .custom-trials {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .trial-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      transition: transform 0.2s ease;
    }

    .trial-item:hover {
      transform: translateY(-4px);
    }

    .trial-icon {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 18px;
      color: #fff;
      margin-bottom: 8px;
      font-weight: bold;
    }

    .trial-item:nth-child(1) .trial-icon {
      background-color: #e4e8ff;
    }

    .trial-item:nth-child(2) .trial-icon {
      background-color: #e0f7ec;
    }

    .trial-item:nth-child(3) .trial-icon {
      background-color: #fff1dc;
    }

    .trial-value {
      font-size: 20px;
      color: #333;
      font-weight: 600;
    }

    .trial-label {
      font-size: 12px;
      color: #999;
    }

    .average-display {
      margin-top: 14px;
      font-size: 18px;
      color: #555;
      font-weight: 600;
      background-color: #f2f3f7;
      padding: 6px 0;
      border-radius: 6px;
      width: 60px;
      margin: 10px auto 0;
    }
    .metric-fields {
      padding: 10px;
      border: 1px solid #00000057;
      border-radius: 6px;
    }
    .metric-select-field {
      display: flex;
      justify-content: end;
      align-items: center;
      padding: 10px;
    }
    .parameter-card {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 12px;
      display: none; /* Hidden by default */
    }
  </style>

@php
$icons = ['🏋️', '⚕️', '⏱️', '🚀', '🌟', '🔥', '💡', '✨', '🛠️']; // Add more icons as needed
@endphp

<div class="metric-select-field">
  <select id="metricDropdown" class="form-select form-select-lg mb-3 metric-fields" aria-label=".form-select-lg example" onchange="onMetricChange()">
    <option selected disabled>Select a metric</option>
    @foreach($metric as $item)
    <option value="{{$item->id}}">{{$item->name}}</option>
    @endforeach
  </select>
</div>

<!-- Parameter card initially hidden -->
<div class="parameter-card" id="parameterCard"></div>

<script>
// Function to retrieve the user ID from the URL
function getUserIdFromUrl() {
    var url = window.location.pathname;
    var parts = url.split('/'); // Split the URL by '/'
    return  parts[parts.length - 1];
}

// Function to handle dropdown change
function onMetricChange() {
  const metricDropdown = document.getElementById('metricDropdown');
  const selectedMetricId = metricDropdown.value;
  const userId = getUserIdFromUrl();
  const parameterCard = document.getElementById('parameterCard');

  // Ensure a valid selection is made
  if (!selectedMetricId || !userId) {
    console.log('No metric selected or user ID missing');
    parameterCard.style.display = 'none'; // Ensure the card remains hidden
    return;
  }

  // Hide the parameter card while fetching new data
  parameterCard.style.display = 'none';
  console.log('Fetching data for metric:', selectedMetricId);

  fetch(`/admin/user_evaluation/history/${userId}/${selectedMetricId}`, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json'
    },
  })
    .then(response => response.json())
    .then(data => {
      // Clear the existing content in the parameter card
      parameterCard.innerHTML = '';

      // Populate the parameter card with the new data
      data.forEach(item => {
        // Create card element
        const card = document.createElement('div');
        card.classList.add('custom-card');

        // Title
        const title = document.createElement('div');
        title.classList.add('custom-title');
        title.textContent = item.parameter.name;
        card.appendChild(title);

        // Trials container
        const trialsContainer = document.createElement('div');
        trialsContainer.classList.add('custom-trials');

        // Array of random icons
        const icons = ['🏋️', '⚕️', '⏱️', '🚀', '🌟', '🔥', '💡', '✨', '🛠️'];
        
        // Function to get a random icon
        const getRandomIcon = () => icons[Math.floor(Math.random() * icons.length)];

        // Trial 1
        const trial1 = document.createElement('div');
        trial1.classList.add('trial-item');
        trial1.innerHTML = `
          <div class="trial-icon" style="background-color: #e4e8ff;">${getRandomIcon()}</div>
          <div class="trial-value">${item.trial_1}</div>
          <div class="trial-label">Trial 1</div>
        `;
        trialsContainer.appendChild(trial1);

        // Trial 2
        const trial2 = document.createElement('div');
        trial2.classList.add('trial-item');
        trial2.innerHTML = `
          <div class="trial-icon" style="background-color: #e0f7ec;">${getRandomIcon()}</div>
          <div class="trial-value">${item.trial_2}</div>
          <div class="trial-label">Trial 2</div>
        `;
        trialsContainer.appendChild(trial2);

        // Trial 3
        const trial3 = document.createElement('div');
        trial3.classList.add('trial-item');
        trial3.innerHTML = `
          <div class="trial-icon" style="background-color: #fff1dc;">${getRandomIcon()}</div>
          <div class="trial-value">${item.trial_3}</div>
          <div class="trial-label">Trial 3</div>
        `;
        trialsContainer.appendChild(trial3);

        // Add trials container to card
        card.appendChild(trialsContainer);

        // Average display
        const averageDisplay = document.createElement('div');
        averageDisplay.classList.add('average-display');
        averageDisplay.textContent = parseFloat(item.avg_trials_count).toFixed(2);
        card.appendChild(averageDisplay);

        // Add the card to the parameter card container
        parameterCard.appendChild(card);
      });

      // Show the parameter card after successful data fetch
      parameterCard.style.display = 'grid';
    })
    .catch(error => {
      console.error('Error:', error);
      // If there's an error, ensure the parameter card stays hidden
      parameterCard.style.display = 'none';
    });
}
</script>

