<template>
  <div style="background:#fff; border-radius:5px; box-shadow:0 2px 16px rgba(99,90,180,.04); padding:30px 26px;">
    <h2 style="margin:0 0 18px 0; font-size:17px; font-weight:bold; color:#404670;">Media Manager</h2>
    <div style="display:flex;align-items:center;gap:8px;">
      <button style="background:#6b8efd;color:#fff;font-weight:600;padding:6px 14px 7px 14px;font-size:14px;border-radius:3px;border:none;">Upload...</button>
      <button style="background:#20bcd5;color:#fff;font-weight:600;padding:6px 13px 7px 13px;font-size:14px;border-radius:3px;border:none;">Manage Media Tags</button>
      <div style="margin-left:auto;display:flex;gap:10px;align-items:center;">
        <select style="height:30px;border-radius:3px;border:1px solid #bbb;font-size:15px;padding:3px 8px;">
          <option>Search By Title</option>
        </select>
        <input style="height:30px;border-radius:3px;border:1px solid #bbb;font-size:15px;padding:3px 8px;outline:none;width:110px;" placeholder="Search..."/>
        <button style="background:#6b8efd;color:#fff;font-weight:600;padding:5px 16px 6px 16px;font-size:14px;border-radius:3px;border:none;">Go</button>
        <button style="background:#e0e5f5;color:#7e8a9b;font-weight:600;padding:5px 16px 6px 16px;font-size:14px;border-radius:3px;border:none;">Reset</button>
      </div>
    </div>
    <div style="background:#f5f6fa; height:330px; margin-top:15px; border-radius:2px; border:1px solid #ececec; min-height:180px;">
      <!-- Media grid/list empty, screenshot ki tarah -->
    </div>
  </div>
</template>

