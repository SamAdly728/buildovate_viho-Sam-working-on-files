<template>
  <div class="p-3">
    <div class="card">
      <div class="card-body">
        <label for="">Role</label>
        <select class="form-control" name="" id="">
          <option v-for="r in roles" :key="r.id" :value="r.id">{{ r.role_display_name }}</option>
        </select>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ['roles']
}
</script>