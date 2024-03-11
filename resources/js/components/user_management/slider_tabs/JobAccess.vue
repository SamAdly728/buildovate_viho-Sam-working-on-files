<template>
  <div class="card b-primary-v2 b-radius-10 shadow-sm mt-3">
    <div class="card-body">
      <small class="f-w-700 d-block">New Jobs</small>
      <div class="mt-2">
        <label class="d-block">
          <input class="checkbox_animated" type="checkbox" >
          <small class="f-12 text-muted f-w-500">Grant [name] automatic access to new jobs and templates</small>
        </label>
      </div>

      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>
                Access
                <input class="d-block checkbox_animated m-l-15" type="checkbox" >
              </th>
              <th>
                Notifications
                <input class="d-block checkbox_animated m-l-35" type="checkbox" >
              </th>
              <th class="pb-4">Job Name</th>
              <th class="pb-4">Job Status</th>
              <th class="pb-4">Group</th>
              <th class="pb-4">Date Opened</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
<script setup>
</script>