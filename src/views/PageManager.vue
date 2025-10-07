<template>
  <div style="background:#fff; border-radius:5px; box-shadow:0 2px 16px rgba(99,90,180,.04); padding:30px 26px;">
    <h2 style="margin:0 0 26px 0; font-size:20px; font-weight:bold; color:#404670;">Page Manager</h2>
    <div style="margin-bottom:22px; display:flex;align-items:center;">
      <button style="background:#635ada;color:#fff;padding:7px 26px;font-size:15px;font-weight:bold;border-radius:4px;border:none;outline:none;">Create</button>
      <input placeholder="Search..." style="margin-left:auto;padding:7px 14px;border-radius:3px;border:1px solid #b8bfd7;margin-right:6px;" />
      <button style="background:#4375e1;color:#fff;border:0;border-radius:4px;padding:7px 18px;font-weight:600;">Go</button>
      <button style="background:#b8bfd7;color:#404670;border:0;border-radius:4px;padding:7px 13px;font-weight:600;margin-left:8px;">Reset</button>
    </div>
    <table style="width:100%;border-spacing:0;margin-top:10px;">
      <thead>
        <tr style="background:#f5f6fa;">
          <th style="padding:12px 8px;text-align:left;color:#778;">Actions</th>
          <th style="padding:12px 8px;text-align:left;color:#778;">Page Title</th>
          <th style="padding:12px 8px;text-align:left;color:#778;">Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="padding:8px;">
            <button style="background:#55be71;color:#fff;border:none;padding:3px 8px;margin-right:5px;border-radius:3px;"><i class="fa fa-pencil"></i></button>
            <button style="background:#e84b51;color:#fff;border:none;padding:3px 8px;border-radius:3px;"><i class="fa fa-trash"></i></button>
          </td>
          <td style="padding:8px;color:#283758;">About Us</td>
          <td style="padding:8px;color:#27c47b;font-weight:600;">PUBLIC</td>
        </tr>
        <tr>
          <td style="padding:8px;">
            <button style="background:#55be71;color:#fff;border:none;padding:3px 8px;margin-right:5px;border-radius:3px;"><i class="fa fa-pencil"></i></button>
            <button style="background:#e84b51;color:#fff;border:none;padding:3px 8px;border-radius:3px;"><i class="fa fa-trash"></i></button>
          </td>
          <td style="padding:8px;color:#283758;">Contact Us</td>
          <td style="padding:8px;color:#27c47b;font-weight:600;">PUBLIC</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

