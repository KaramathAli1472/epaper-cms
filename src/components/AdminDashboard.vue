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
        <span style="font-size:20px; margin-right:12px;">⟳</span> Expiry 11 Feb 2026
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
              Total: 5120.00 MB
            </div>
            <div style="flex:1; background:#ef5d6d; color:#fff; font-size:16px; font-weight:600; padding:10px 0; text-align:center;">
              Used: 5082.13 MB
            </div>
            <div style="flex:1; background:#30a188; color:#fff; font-size:16px; font-weight:600; padding:10px 0; text-align:center;">
              Available: 37.87 MB
            </div>
          </div>
        </div>
      </div>
      <!-- Traffic Usage Card -->
      <div style="width:620px; max-width:640px;">
        <div class="card mb-3" style="overflow:hidden; min-height:140px;">
          <div class="card-header" style="background:#6274ea;color:#fff;font-size:18px; padding:18px 16px;">
            Traffic Usage In Pageviews for October 2025
          </div>
          <div class="card-body" style="padding:14px 0 14px 0; text-align:center; min-height:100px;">
            <canvas id="pie2" width="180" height="100" style="max-width:100%;"></canvas>
          </div>
          <div style="display:flex;">
            <div style="flex:1; background:#2989d7; color:#fff; font-size:16px; font-weight:600; padding:10px 0; text-align:center;">
              Total: 300000
            </div>
            <div style="flex:1; background:#ef5d6d; color:#fff; font-size:16px; font-weight:600; padding:10px 0; text-align:center;">
              Used: 1069
            </div>
            <div style="flex:1; background:#30a188; color:#fff; font-size:16px; font-weight:600; padding:10px 0; text-align:center;">
              Available: 298931
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
import { onMounted } from 'vue';

onMounted(() => {
  import('chart.js/auto').then((ChartJs) => {
    new ChartJs.Chart(document.getElementById('pie1'), {
      type: 'pie',
      data: {
        labels: ['Used', 'Available'],
        datasets: [{ data: [5082.13, 37.87], backgroundColor: ['#e5383b', '#2a9d8f'] }]
      },
      options: { plugins: { legend: { position: 'right' } } }
    });
    new ChartJs.Chart(document.getElementById('pie2'), {
      type: 'pie',
      data: {
        labels: ['Used', 'Available'],
        datasets: [{ data: [1069, 298931], backgroundColor: ['#e5383b', '#2a9d8f'] }]
      },
      options: { plugins: { legend: { position: 'right' } } }
    });
    new ChartJs.Chart(document.getElementById('lineChart'), {
      type: 'line',
      data: {
        labels: ['09 Sep', '12', '15', '18', '21', '24', '27', '30', '03 Oct'],
        datasets: [{
          label: 'Pageviews',
          data: [250,180,260,220,310,200,290,230,300],
          borderColor: '#3b82f6',
          fill: true,
          backgroundColor: 'rgba(59,130,246,0.12)',
          tension: 0.3
        }]
      },
      options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });
  });
});
</script>

