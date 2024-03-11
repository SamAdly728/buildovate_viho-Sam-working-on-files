<script setup></script>
<template>
  <div
    class="modal fade"
    id="invite-a-pro"
    tabindex="-1"
    role="dialog"
    aria-labelledby="monthlyOverHead"
    aria-hidden="true"
  >
    <div class="modal-dialog zoomIn animated" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="">Invite a Pro</h5>
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
                <span class="input-group-text text-muted">Name:</span>
                <input
                  id="over-head-title"
                  class="form-control"
                  type="text"
                  placeholder="Name..."
                />
              </div>
              <div class="input-group mb-2">
                <span class="input-group-text text-muted">Email:</span>
                <input
                  id="over-head-amount"
                  class="form-control"
                  type="number"
                  placeholder="Email..."
                />
              </div>
              <div class="input-group">
                <span class="input-group-text text-muted"
                  >Mobile Phone Number:</span
                >
                <input
                  id="over-head-amount"
                  class="form-control"
                  type="number"
                  placeholder="Phone number..."
                />
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary">Invite Pro Now</button>
        </div>
      </div>
    </div>
  </div>
</template>
