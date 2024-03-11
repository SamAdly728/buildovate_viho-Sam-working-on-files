<style>
.custom-modal-body-background {
  background: #ececec !important;
}

</style>
<template>
  <div class="p-3">
    <div class="card rounded-3">
      <div class="card-header rounded-3 p-3">
        <h5 class="mb-0"><span class="text-muted">Subscription Information</span></h5>
      </div>
      <hr class="mb-0 mt-0">
      <div class="card-body p-3 ">
        <div class="card rounded-3 shadow-sm shadow-showcase">
          <div class="card-header rounded-3">
            <div class="card-title d-flex align-items-center justify-content-between">
              <div class="d-inline">
                <p class="f-w-700 mb-0"><span class="badge badge-warning badge-pill">Active</span></p>
                <h4 class="text-muted">Buildertrend Offerings</h4>
              </div>
              <div class="d-inline">
                <button class="btn btn-outline-primary btn-sm mr-1">Cancel Subscription</button>
                <button class="btn btn-primary btn-sm">Manage Subscription</button>
              </div>
            </div>
          </div>
          <hr class="pt-0 pb-0 mt-0 mb-0">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="text-muted">Billing Info</h5>
                <div>
                  <h6 class="d-inline mr-2 text-muted">Next Payment Date:</h6>
                  <p class="d-inline text-muted">Dec 4, 2023</p>
                </div>
                <div>
                  <h6 class="d-inline mr-2 text-muted">Next Payment:</h6>
                  <p class="d-inline text-muted">$365.00 USD + tax (if applicable)</p>
                </div>
              </div>
              <div class="col">
                <h6 class="text-muted">Current Plan</h6>
                <div class="card rounded-3 shadow-sm shadow-showcase">
                  <div class="card-body">
                    <p>Advanced</p>
                    <small>
                      For builders who need to create estimates with confidence and are looking for fuller financial control. All tools from Essential are included.
                    </small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card rounded-3">
<!--      <div class="card-header pb-0">-->
<!--        <h5>Basic Tabs</h5>-->
<!--      </div>-->
      <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item"><a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Payment Info</a></li>
          <li class="nav-item"><a class="nav-link" id="profile-tabs" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Payment History</a></li>
          <li class="nav-item"><a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Order Forms</a></li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="mt-4">
              <div class="row">
                <div class="col">
              <h6>Payment Method</h6>
              <p>Credit</p>
              <small>Paying with Card</small>
              <div class="col-md-12">
                <div class="card rounded-3 shadow-sm">
                  <div class="card-body">
                    <div class="nav flex-column nav-pills border-tab nav-left" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                      <a class="nav-link pb-0 pt-0 active" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">
                        <div class="d-flex items-center">
                          <img style="width: 80px; height: 80px" :src="visa" alt="">
                          <div class="ml-2 mt-1">
                            <h5 class="pt-0 pb-0 mt-0 mb-0"><span>Ending in 1234</span></h5>
                            <small class="pt-0 pb-0 mt-0 mb-0">Visa</small>
                          </div>
                        </div>
                      </a>
                      <a class="nav-link pb-0 pt-0" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                        <div class="d-flex items-center">
                          <img style="width: 80px; height: 80px" :src="visa" alt="">
                          <div class="ml-2 mt-1">
                            <h5 class="pt-0 pb-0 mt-0 mb-0"><span>Ending in 1234</span></h5>
                            <small class="pt-0 pb-0 mt-0 mb-0">Visa</small>
                          </div>
                        </div>
                      </a>
                      <a class="nav-link pb-3 pt-3" id="v-pills-messages-tab" data-bs-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">
                        <div class="d-flex items-center">
                          <img class="ml-2" style="width: 66px; height: 45px" :src="master" alt="">
                          <div class="ml-4 mt-1">
                            <h5 class="pt-0 pb-0 mt-0 mb-0"><span>Ending in 1234</span></h5>
                            <small class="pt-0 pb-0 mt-0 mb-0">Master</small>
                          </div>
                        </div>
                      </a>
                      <a class="nav-link pb-0 pt-0" id="v-pills-settings-tab" data-bs-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                        <div class="d-flex items-center">
                          <img style="width: 80px; height: 80px" :src="visa" alt="">
                          <div class="ml-2 mt-1">
                            <h5 class="pt-0 pb-0 mt-0 mb-0"><span>Ending in 1234</span></h5>
                            <small class="pt-0 pb-0 mt-0 mb-0">Visa</small>
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="card rounded-3 shadow-sm">
                  <div class="card-body custom-modal-body-background">
                    <div class="justify-content-center text-center">
                      <a class="" href="#"><u>Choose another way to pay</u></a>
                    </div>
                  </div>
                </div>
              </div>
                </div>
                <div class="col">
                  <div style="margin-top: 55px">
                    <h4>Billing Address</h4>
                    <div class="col-md-12">
                      <div class="card rounded-3 shadow-sm">
                        <div class="card-body">
                          <div class="row">
                            <div class="col">
                              <div class="mb-3">
                                <label class="form-label" for="exampleFormControlSelect3">Country</label>
                                <select class="form-select" id="exampleFormControlSelect3">
                                  <option>1</option>
                                  <option>2</option>
                                  <option>3</option>
                                  <option>4</option>
                                  <option>5</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col">
                              <div class="mb-3">
                                <label class="form-label" for="exampleFormControlSelect3">Street Address</label>
                                <input class="form-control" id="exampleFormControlInput1" type="email" placeholder="Address...">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col">
                              <div class="mb-3">
                                <label class="form-label" for="exampleFormControlInput1">City</label>
                                <input class="form-control" id="exampleFormControlInput1" type="email" placeholder="City...">
                              </div>
                            </div>
                            <div class="col">
                              <div class="mb-3">
                                <label class="form-label" for="exampleFormControlSelect3">State</label>
                                <select class="form-select" id="exampleFormControlSelect3">
                                  <option>1</option>
                                  <option>2</option>
                                  <option>3</option>
                                  <option>4</option>
                                  <option>5</option>
                                </select>
                              </div>
                            </div>
                            <div class="col">
                              <div class="mb-3">
                                <label class="form-label" for="exampleFormControlSelect3">Zip Code</label>
                                <input class="form-control" id="exampleFormControlInput1" type="email" placeholder="Zip code...">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="mt-4">
              <div class="d-flex justify-content-between">
                <h6 class="ml-3">Payment History</h6>
                <a href="#" class="btn btn-light btn-sm"><span class="icon-filter"></span> Filter</a>
              </div>
              <table class="table table-hover">
                <thead>
                <th>Due Date</th>
                <th>Payment Date</th>
                <th>Description</th>
                <th>Payment Method</th>
                <th>Amount Paid</th>
                <th></th>
                </thead>
                <tbody>
                <tr>
                  <td>Nov 4, 2023</td>
                  <td>Nov 4, 2023</td>
                  <td>Advanced</td>
                  <td>************1234</td>
                  <td>$365.00 + ($0.00 tax)</td>
                  <td><a href="#"><i class="icofont icofont-printer h4"></i></a></td>
                </tr>
                <tr>
                  <td>Nov 4, 2023</td>
                  <td>Nov 4, 2023</td>
                  <td>Advanced</td>
                  <td>************1234</td>
                  <td>$365.00 + ($0.00 tax)</td>
                  <td><a href="#"><i class="icofont icofont-printer h4"></i></a></td>
                </tr>
                <tr>
                  <td>Nov 4, 2023</td>
                  <td>Nov 4, 2023</td>
                  <td>Advanced</td>
                  <td>************1234</td>
                  <td>$365.00 + ($0.00 tax)</td>
                  <td><a href="#"><i class="icofont icofont-printer h4"></i></a></td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <div class="mt-4">
              <div class="d-flex justify-content-between">
                <h6 class="ml-3">Order Form Date</h6>
                <a href="#" class="btn btn-light btn-sm"><span class="icon-filter"></span> Filter</a>
              </div>
              <table class="table table-hover">
                <tbody>
                <tr>
                  <td>
                    <div class="d-flex item-center justify-content-between">
                      <span>Jul 4, 2023</span>
                      <i class="icofont icofont-download-alt h4 text-primary"></i>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="d-flex item-center justify-content-between">
                      <span>Jul 5, 2023</span>
                      <i class="icofont icofont-download-alt h4 text-primary"></i>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="d-flex item-center justify-content-between">
                      <span>Jul 8, 2023</span>
                      <i class="icofont icofont-download-alt h4 text-primary"></i>
                    </div>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>


  </div>
</template>
<script>
export default {
  data() {
    return {
      visa: window.location.origin+'/assets/images/visa.png',
      master: window.location.origin+'/assets/images/master.png',
    }
  }
}
</script>