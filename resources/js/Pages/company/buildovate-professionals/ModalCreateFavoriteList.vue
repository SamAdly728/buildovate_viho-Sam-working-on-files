<script setup></script>
<template>
  <div
    class="modal fade"
    id="create-favorite-list"
    tabindex="-1"
    role="dialog"
    aria-labelledby="monthlyOverHead"
    aria-hidden="true"
  >
    <div class="modal-dialog zoomIn animated" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="">Name your new list</h5>
          <button
            class="btn-close"
            type="button"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="input-group mb-2">
                <input
                  id="over-head-title"
                  class="form-control"
                  type="text"
                  placeholder="List Name"
                />
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary">Ok</button>
        </div>
      </div>
    </div>
  </div>
</template>
