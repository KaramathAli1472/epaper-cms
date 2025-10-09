<template>
  <div>
    <!-- Top horizontal actions bar -->
    <div style="display:flex; gap:24px; margin:18px 0 30px 0;">
      <div style="flex:1; background:#5c6be9; color:#fff; font-weight:bold; font-size:20px; padding:22px 0 20px 0; border-radius:4px; display:flex; align-items:center; justify-content:center;">
        <span style="font-size:20px; margin-right:12px;">✔️</span> Publish Epaper
      </div>
      <div style="flex:1; background:#36a595; color:#fff; font-weight:bold; font-size:20px; padding:22px 0 20px 0; border-radius:4px; display:flex; align-items:center; justify-content:center;">
        <span style="font-size:20px; margin-right:12px;">🌐</span> Change Domain
      </div>
      <div style="flex:1; background:#ffc107; color:#222; font-weight:bold; font-size:20px; padding:22px 0 20px 0; border-radius:4px; display:flex; align-items:center; justify-content:center;">
        <span style="font-size:20px; margin-right:12px;">❓</span> Help/Support
      </div>
      <div style="flex:1; background:#f4697a; color:#fff; font-weight:bold; font-size:20px; padding:22px 0 20px 0; border-radius:4px; display:flex; align-items:center; justify-content:center;">
        <span style="font-size:20px; margin-right:12px;">⟳</span> Expiry {{ expiryDate }}
      </div>
    </div>

    <!-- Centered enlarged usage cards -->
    <div style="display:flex; gap:20px; margin-bottom:16px; justify-content:center; align-items:flex-start;">
      <!-- Disk Usage Card -->
      <div style="width:620px; max-width:640px;">
        <div class="card mb-3" style="overflow:hidden; min-height:140px;">
          <div class="card-header" style="background:#6274ea;color:#fff;font-size:18px; padding:18px 16px;">Disk Usage</div>
          <div class="card-body" style="padding:14px 0 14px 0; text-align:center; min-height:100px;">
            <canvas id="pie1" width="180" height="100" style="max-width:100%;"></canvas>
          </div>
          <div style="display:flex;">
            <div style="flex:1; background:#2989d7; color:#fff; font-size:16px; font-weight:600; padding:10px 0; text-align:center;">
              Total: 0.00 MB
            </div>
            <div style="flex:1; background:#ef5d6d; color:#fff; font-size:16px; font-weight:600; padding:10px 0; text-align:center;">
              Used: 0
            </div>
            <div style="flex:1; background:#30a188; color:#fff; font-size:16px; font-weight:600; padding:10px 0; text-align:center;">
              Available: 5120.0 MB
            </div>
          </div>
        </div>
      </div>

      <!-- Traffic Usage Card -->
      <div style="width:620px; max-width:640px;">
        <div class="card mb-3" style="overflow:hidden; min-height:140px;">
          <!-- Dynamic header for month/year -->
          <div class="card-header" style="background:#6274ea;color:#fff;font-size:18px; padding:18px 16px;">
            Traffic Usage In Pageviews for {{ currentMonthYear }}
          </div>
          <div class="card-body" style="padding:14px 0 14px 0; text-align:center; min-height:100px;">
            <canvas id="pie2" width="180" height="100" style="max-width:100%;"></canvas>
          </div>
          <div style="display:flex;">
            <div style="flex:1; background:#2989d7; color:#fff; font-size:16px; font-weight:600; padding:10px 0; text-align:center;">
              Total: 300000
            </div>
            <div style="flex:1; background:#ef5d6d; color:#fff; font-size:16px; font-weight:600; padding:10px 0; text-align:center;">
              Used: 0
            </div>
            <div style="flex:1; background:#30a188; color:#fff; font-size:16px; font-weight:600; padding:10px 0; text-align:center;">
              Available: 300000
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card mt-3">
      <div class="card-header">Website Traffic</div>
      <div class="card-body">
        <canvas id="lineChart" height="80"></canvas>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';

// Reactive variables
const currentMonthYear = ref('');
const expiryDate = ref('');

// Function to dynamically generate date labels for the current month
function generateDatesForMonth() {
  const today = new Date();
  const month = today.getMonth();
  const year = today.getFullYear();
  const monthStr = today.toLocaleString('default', { month: 'long' }); // Full month name
  currentMonthYear.value = `${monthStr} ${year}`; // Set reactive month/year for header

  const dates = [];
  const lastDay = new Date(year, month + 1, 0).getDate(); // Last day of month
  for (let i = 1; i <= lastDay; i += 3) {
    const date = new Date(year, month, i);
    const day = String(date.getDate()).padStart(2, '0');
    dates.push(`${day} ${monthStr}`);
  }
  return dates;
}

// Function to calculate expiry date (yearly, half-yearly, quarterly)
function calculateExpiry(frequency = 'yearly') {
  const today = new Date();
  let expiry = new Date(today);

  if (frequency === 'yearly') {
    expiry.setFullYear(expiry.getFullYear() + 1);
  } else if (frequency === 'half-yearly') {
    expiry.setMonth(expiry.getMonth() + 6);
  } else if (frequency === 'quarterly') {
    expiry.setMonth(expiry.getMonth() + 3);
  }

  const day = String(expiry.getDate()).padStart(2, '0');
  const month = expiry.toLocaleString('default', { month: 'short' });
  const year = expiry.getFullYear();
  expiryDate.value = `${day} ${month} ${year}`;
}

onMounted(() => {
  generateDatesForMonth(); // sets currentMonthYear
  calculateExpiry('yearly'); // You can change to 'half-yearly' or 'quarterly'

  import('chart.js/auto').then((ChartJs) => {
    // Pie Chart 1 (Disk Usage)
    new ChartJs.Chart(document.getElementById('pie1'), {
      type: 'pie',
      data: {
        labels: ['Used', 'Available'],
        datasets: [{ data: [0, 5120.0], backgroundColor: ['#e5383b', '#2a9d8f'] }]
      },
      options: { plugins: { legend: { position: 'right' } } }
    });

    // Pie Chart 2 (Traffic Usage)
    new ChartJs.Chart(document.getElementById('pie2'), {
      type: 'pie',
      data: {
        labels: ['Used', 'Available'],
        datasets: [{ data: [0, 300000], backgroundColor: ['#e5383b', '#2a9d8f'] }]
      },
      options: { plugins: { legend: { position: 'right' } } }
    });

    // Line Chart (Website Traffic)
    const lineLabels = generateDatesForMonth();
    const lineData = Array(lineLabels.length).fill(0);

    new ChartJs.Chart(document.getElementById('lineChart'), {
      type: 'line',
      data: {
        labels: lineLabels,
        datasets: [{
          label: 'Pageviews',
          data: lineData,
          borderColor: '#3b82f6',
          fill: true,
          backgroundColor: 'rgba(59,130,246,0.12)',
          tension: 0.3
        }]
      },
      options: {
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
      }
    });
  });
});
</script>

