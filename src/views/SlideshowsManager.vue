<template>
  <div style="background:#fff; border-radius:5px; box-shadow:0 2px 16px rgba(99,90,180,.04); padding:30px 26px;">
    <h2 style="margin:0 0 18px 0; font-size:19px; font-weight:bold; color:#404670;">Slideshows Manager</h2>
    <div style="background:#f5f6fa;padding:14px 18px;border-radius:4px 4px 0 0;">
      <button style="background:#3b6deb;color:#fff;font-weight:600;padding:6px 17px;border-radius:4px;border:none;">New Slideshow</button>
    </div>
    <table style="width:100%;border-spacing:0;margin-top:0;">
      <thead>
        <tr style="background:#f5f6fa;">
          <th style="padding:10px 12px;text-align:left;color:#778;">Actions</th>
          <th style="padding:10px 12px;text-align:left;color:#778;">Slideshow Name</th>
        </tr>
      </thead>
      <tbody>
        <!-- Agar data nahi hai toh blank row show karo (screenshot ke hisaab se) -->
      </tbody>
    </table>
  </div>
</template>

