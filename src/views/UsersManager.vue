<template>
  <div style="background:#fff; border-radius:5px; box-shadow:0 2px 16px rgba(99,90,180,0.04); padding:30px 26px;">
    <h2 style="margin:0 0 18px 0; font-size:19px; font-weight:bold; color:#404670;">Users Manager</h2>
    <div style="display:flex;align-items:center;gap:8px;">
      <button style="background:#635ada;color:#fff;font-weight:600;padding:7px 20px;font-size:15px;border-radius:4px;border:none;">New User</button>
      <div style="margin-left:auto;display:flex;align-items:center; gap:7px;">
        <select style="height:27px; padding:0 8px; border-radius:3px; border:1px solid #bbb;">
          <option>-- Bulk Actions --</option>
        </select>
        <button style="background:#3b6deb;color:#fff;font-size:13px;padding:6px 15px;border-radius:4px; border:none;">Apply</button>
        <select style="height:27px; padding:0 8px; border-radius:3px; border:1px solid #bbb;">
          <option>--All/Any--</option>
        </select>
        <select style="height:27px; padding:0 8px; border-radius:3px; border:1px solid #bbb;">
          <option>--All/Any--</option>
        </select>
        <input type="date" style="height:27px;padding:0 7px; border-radius:3px; border:1px solid #bbb;" />
        <input type="date" style="height:27px;padding:0 7px; border-radius:3px; border:1px solid #bbb;" />
        <input placeholder="Search..." style="height:27px;padding:0 7px; border-radius:3px; border:1px solid #bbb;" />
        <button style="background:#3b6deb;color:#fff;font-size:13px;padding:6px 16px;border-radius:4px; border:none;">Go</button>
        <button style="background:#e0e5f5;color:#778;font-size:13px;padding:6px 16px;border-radius:4px; border:none;">Reset</button>
        <button style="background:#20bcd5;color:#fff;font-size:13px;padding:6px 16px;border-radius:4px; border:none;">Export</button>
      </div>
    </div>
    <table style="width:100%;margin-top:18px;border-spacing:0;">
      <thead>
        <tr style="background:#f5f6fa;">
          <th style="padding:10px 9px;text-align:left;color:#778;">Actions</th>
          <th style="padding:10px 9px;text-align:left;color:#778;">ID</th>
          <th style="padding:10px 9px;text-align:left;color:#778;">Fullname</th>
          <th style="padding:10px 9px;text-align:left;color:#778;">Email</th>
          <th style="padding:10px 9px;text-align:left;color:#778;">Mobile</th>
          <th style="padding:10px 9px;text-align:left;color:#778;">Role</th>
          <th style="padding:10px 9px;text-align:left;color:#778;">Regt Date</th>
          <th style="padding:10px 9px;text-align:left;color:#778;">Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="padding:7px 9px;">
            <button style="background:#55be71;color:#fff;border:none;padding:3px 9px;border-radius:3px;"><i class="fa fa-pencil"></i></button>
          </td>
          <td style="padding:7px 9px;">1</td>
          <td style="padding:7px 9px;">karamat</td>
          <td style="padding:7px 9px;">karamatali472@gmail.com</td>
          <td style="padding:7px 9px;"></td>
          <td style="padding:7px 9px; color:#cf455a; font-weight:600;">Super Admin</td>
          <td style="padding:7px 9px;">November 26, 2018, 10:04 pm</td>
          <td style="padding:7px 9px; color:#27c47b; font-weight:600;">ACTIVE</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

