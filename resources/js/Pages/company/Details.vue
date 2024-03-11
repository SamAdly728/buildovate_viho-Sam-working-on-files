<style scoped>
.mouseOver{
  cursor: pointer;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

.green {
  background-color: #0f5132 !important;
  color: white !important;
}

.border-color {
  border-color: #0f5132 !important;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: #2b786a !important;
  border-radius: 10px !important;
}
</style>
<template>
  <div class="p-15 overflow-auto custom-scrollbar">
    <div class="alert alert-light dark" role="alert">
      <p class="text-muted">Manage all your company information here, such as phone numbers, emails, and addresses.</p>
    </div>
    <div class="">
      <div class="email-wrap bookmark-wrap">
        <div class="row">
          <div class="col-xl-3 box-col-4 xl-30" style="">
            <div class="email-sidebar">
              <div class="email-left-aside">
                <div class="card">
                  <div class="card-body">
                    <div class="email-app-sidebar left-bookmark">
                      <ul class="nav main-menu" role="tablist">
                        <li>
                          <a id="pills-created-tab" data-bs-toggle="pill" href="#pills-created" role="tab" aria-controls="pills-created" aria-selected="true">
                          <span class="title">
                            <div class="row">
                              <div class="col-md-1"><i class="fa fa-info-circle"></i></div>
                              <div class="col-md-10">Basic Information</div>
                            </div>
                          </span>
                          </a>
                        </li>
                        <li>
                          <a class="show" id="pills-todaytask-tab" data-bs-toggle="pill" href="#pills-todaytask" role="tab" aria-controls="pills-todaytask" aria-selected="false">
                          <span class="title">
                            <div class="row">
                              <div class="col-md-1"><i class="fa fa-clock-o"></i></div>
                              <div class="col-md-10">Hours</div>
                            </div>
                          </span>
                          </a>
                        </li>
                        <li>
                          <a class="show" id="pills-delayed-tab" data-bs-toggle="pill" href="#pills-delayed" role="tab" aria-controls="pills-delayed" aria-selected="false">
                          <span class="title">
                            <div class="row">
                              <div class="col-md-1"><i class="fa fa-dollar"></i></div>
                              <div class="col-md-10">Monthly Overhead</div>
                            </div>
                          </span>
                          </a>
                        </li>
                        <li>
                          <a class="show" id="pills-upcoming-tab" data-bs-toggle="pill" href="#pills-upcoming" role="tab" aria-controls="pills-upcoming" aria-selected="false">
                          <span class="title">
                            <div class="row">
                              <div class="col-md-1"><i class="fa fa-phone-square"></i></div>
                              <div class="col-md-10">Phone Numbers</div>
                            </div>
                          </span>
                          </a>
                        </li>
                        <li>
                          <a class="show" id="pills-weekly-tab" data-bs-toggle="pill" href="#pills-weekly" role="tab" aria-controls="pills-weekly" aria-selected="false">
                          <span class="title">
                            <div class="row">
                              <div class="col-md-1"><i class="fa fa-inbox"></i></div>
                              <div class="col-md-10">Emails</div>
                            </div>
                          </span>
                          </a>
                        </li>
                        <li>
                          <a class="show" id="pills-monthly-tab" data-bs-toggle="pill" href="#pills-monthly" role="tab" aria-controls="pills-monthly" aria-selected="false">
                          <span class="title">
                            <div class="row">
                              <div class="col-md-1"><i class="fa fa-map-marker"></i></div>
                              <div class="col-md-10">Locations</div>
                            </div>
                          </span>
                          </a>
                        </li>
                        <li>
                          <a class="show" id="pills-assigned-tab" data-bs-toggle="pill" href="#pills-assigned" role="tab" aria-controls="pills-assigned" aria-selected="false">
                          <span class="title">
                            <div class="row">
                              <div class="col-md-1"><i class="fa fa-globe"></i></div>
                              <div class="col-md-10">Websites</div>
                            </div>
                          </span>
                          </a>
                        </li>
                        <li>
                          <a class="show" id="pills-tasks-tab" data-bs-toggle="pill" href="#pills-tasks" role="tab" aria-controls="pills-tasks" aria-selected="false">
                          <span class="title">
                            <div class="row">
                              <div class="col-md-1"><i class="fa fa-code-fork"></i></div>
                              <div class="col-md-10">Social Media</div>
                            </div>
                          </span>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class=" col-xl-9 col-md-12 box-col-8 xl-70">
            <div class="email-right-aside bookmark-tabcontent">
              <div class=" email-body radius-left">
                <div class="">
                  <div class="tab-content">
                    <div class="tab-pane fade active show" id="pills-created" role="tabpanel" aria-labelledby="pills-created-tab">
                      <div class="card mb-0">
                        <div class="card-body">
                          <h3 class="card-title mb-5">Basic Information</h3>
                          <div class="mb-3 m-form__group">
                            <div class="input-group"><span class="input-group-text text-muted" style="width: 230px">Company Name:</span>
                              <input v-model="companyBaseInfo.name" class="form-control" type="text" placeholder="Type here...">
                            </div>
                          </div>
                          <div class="mb-3 m-form__group">
                            <div class="input-group"><span class="input-group-text text-muted" style="width: 230px">Industry:</span>
                              <input v-model="companyBaseInfo.industry" class="form-control" type="text" placeholder="Type here...">
                            </div>
                          </div>
                          <div class="mb-3 m-form__group">
                            <div class="input-group"><span class="input-group-text text-muted" style="width: 230px">License Number:</span>
                              <input v-model="companyBaseInfo.license" class="form-control" type="text" placeholder="Type here...">
                            </div>
                          </div>
                          <div class="mb-3 m-form__group">
                            <div class="input-group"><span class="input-group-text text-muted" style="width: 230px">Federal Tax ID:</span>
                              <input v-model="companyBaseInfo.federalTaxId" class="form-control" type="text" placeholder="Type here...">
                            </div>
                          </div>
                          <div class="mb-3 m-form__group">
                            <div class="input-group"><span class="input-group-text text-muted" style="width: 230px">Timezone:</span>
                              <select v-model="companyBaseInfo.timezone" class="form-control" name="" id="">
                                <option value="">-- SELECT TIMEZONE --</option>
                                <option v-for="timez in timezone" :value="timez.value" v-text="timez.name"></option>
                              </select>
                            </div>
                          </div>
                          <div class="mb-3 m-form__group">
                            <div class="input-group"><span class="input-group-text text-muted" style="width: 230px">Date Format:</span>
                              <select v-model="companyBaseInfo.dateFormatInfo" class="form-control" name="">
                                <option value="">-- SELECT DATE FORMAT --</option>
                                <option v-for="date in dateFormat" :value="date.value" v-text="date.name"></option>
                              </select>
                            </div>
                          </div>
                          <div class="mb-3 m-form__group">
                            <div class="input-group"><span class="input-group-text text-muted" style="width: 230px">Time Format:</span>
                              <select v-model="companyBaseInfo.timeFormatInfo" class="form-control" name="" >
                                <option value>-- SELECT TIME FORMAT --</option>
                                <option v-for="time in timeFormat" :value="time.value" v-text="time.name"></option>
                              </select>
                            </div>
                          </div>
                          <div class="mb-3 m-form__group">
                            <div class="input-group"><span class="input-group-text text-muted" style="width: 230px">First Day or Work Week:</span>
                              <select v-model="companyBaseInfo.dayWorkWeek" class="form-control" name="" id="">
                                <option value="">-- SELECT FIRST DAY OF THE WEEK --</option>
                                <option v-for="day in daysOfWeek" :value="day" v-text="day"></option>
                              </select>
                            </div>
                          </div>
                          <div class="mb-3 m-form__group">
                            <div class="input-group">
                              <span class="input-group-text text-muted" style="width: 230px;height: 35px;">Company Logo:</span>
                              <div class="row p-2" style="width: 79.7%;border: 1px solid #eee;">
                                <div class="col-md-4 p-20">
                                  
                                  <ImageCropper class="mt-5" :options="imageCropperOptions" @croppedImage="getCroppedImage"/>

                                </div>
                                <div class="col-md-8 p-0 text-secondary">
                                  <div class="mt-0">Use on:<br>
                                    <div class="col p-10">
                                      <label  for="chk-ani">
                                        <input v-model="companyBaseInfo.logo_email_message" class="checkbox_animated" id="chk-ani" name="logo_email_message" type="checkbox" checked="">
                                        Email Messages
                                      </label><br>
                                      <label  for="chk-ani1">
                                        <input v-model="companyBaseInfo.logo_client_portal" class="checkbox_animated" id="chk-ani1" name="logo_client_portal" type="checkbox">
                                        Client Portal
                                      </label><br>
                                      <label  for="chk-ani2">
                                        <input v-model="companyBaseInfo.logo_all_pdfs" class="checkbox_animated" id="chk-ani2" name="logo_all_pdfs" type="checkbox">
                                        All PDFs
                                      </label><br>
                                      <label  for="chk-ani3">
                                        <input v-model="companyBaseInfo.logo_financials" class="checkbox_animated" id="chk-ani3" name="logo_financials" type="checkbox">
                                        Financials
                                      </label>
                                      
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="mb-3 m-form__group">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="input-group">
                                    <span
                                      class="input-group-text text-muted"
                                      style="width: 230px"
                                      >Insurance:</span
                                    >

                                    <label class="btn btn-primary ms-3">
                                      <input
                                        name="file"
                                        type="file"
                                        id="file"
                                        accept=".jpg,.jpeg,.jfif,.pjpeg,.pjp,.png,.docx,.doc,.pdf"
                                        @change="handleFile"
                                        class="hidden"
                                      />
                                      Upload
                                    </label>
                                    {{file.name}}
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <a href="https://www.nextinsurance.com/business/general-contractor-insurance/" class="h5" target="_blank">Don't have insurance? Get instant quote now.</a>
                                </div>
                              </div>
                          </div>
                        </div>
                      </div>
                      <div class="float-end mt-5">
                        <button class="btn btn-danger mr-2" @click="resetCompanyBaseInfo(companyBaseInfo)">Reset</button>
                        <button class="btn btn-primary" @click="saveBasicInfo">Save</button>
                      </div>
                    </div>
                    <div class="fade tab-pane" id="pills-todaytask" role="tabpanel" aria-labelledby="pills-todaytask-tab">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title">
                            <span class="h3">Business Hours</span>
                            <input type="text" hidden>
                          </div>
                          <div class="row mt-5">
                          <!-- Sunday -->
                            <div class="col-md-4 col-lg-3">
                              <div class="mt-2">
                                <span class="h5 text-muted f-w-600">Sunday</span>
                              </div>
                            </div>
                            <div class="col-md-4 col-lg-1">
                              <div class="media">
                                <div class="media-body icon-state mt-1">
                                  <label class="switch">
                                    <input @change="toggleCheckHours('sunday')" :checked="companyHoursInfo.sunday.isOn" type="checkbox" ><span class="switch-state"></span>
                                  </label>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 col-lg-6 text-center">
                              <div class="col-lg-5 inline-block">
                                <div class="rounded border" style="background-color: #f3f3f3">
                                  <div class="card-body p-0">
                                    <div class="card-title mt-2 text-center">
                                      <small>Start Time</small>&nbsp;
                                      <small>
                                        <input :disabled="companyHoursInfo.sunday.disabled" v-model="companyHoursInfo.sunday.startTime" class="mouseOver" type="time" style="color: #d94f5c">
                                      </small>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              &nbsp;
                              <div class="col-lg-5 inline-block">
                                <div class="rounded border" style="background-color: #f3f3f3">
                                  <div class="card-body p-0">
                                    <div class="card-title mt-2 text-center">
                                      <small>End Time</small>&nbsp;
                                      <small>
                                        <input :disabled="companyHoursInfo.sunday.disabled" v-model="companyHoursInfo.sunday.endTime" class="mouseOver" type="time" style="color: #d94f5c">
                                      </small>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Monday -->
                            <div class="col-md-4 col-lg-3">
                              <div class="mt-2">
                                <span class="h5 text-muted f-w-600">Monday</span>
                              </div>
                            </div>
                            <div class="col-md-4 col-lg-1">
                              <div class="media">
                                <div class="media-body icon-state mt-1">
                                  <label class="switch">
                                    <input @change="toggleCheckHours('monday')" :checked="companyHoursInfo.monday.isOn" type="checkbox" ><span class="switch-state"></span>
                                  </label>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 col-lg-6 text-center">
                              <div class="col-lg-5 inline-block">
                                <div class="rounded border" style="background-color: #f3f3f3">
                                  <div class="card-body p-0">
                                    <div class="card-title mt-2 text-center">
                                      <small>Start Time</small>&nbsp;
                                      <small>
                                        <input :disabled="companyHoursInfo.monday.disabled" v-model="companyHoursInfo.monday.startTime" class="mouseOver" type="time" style="color: #d94f5c">
                                      </small>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              &nbsp;
                              <div class="col-lg-5 inline-block">
                                <div class="rounded border" style="background-color: #f3f3f3">
                                  <div class="card-body p-0">
                                    <div class="card-title mt-2 text-center">
                                      <small>End Time</small>&nbsp;
                                      <small>
                                        <input :disabled="companyHoursInfo.monday.disabled" v-model="companyHoursInfo.monday.endTime" class="mouseOver" type="time" style="color: #d94f5c">
                                      </small>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <button class="btn btn-danger w-100 mt-1" @click="copyToAll(companyHoursInfo.monday)">Copy to all</button>
                            </div>
                            <!-- Tuesday -->
                            <div class="col-md-4 col-lg-3">
                              <div class="mt-2">
                                <span class="h5 text-muted f-w-600">Tuesday</span>
                              </div>
                            </div>
                            <div class="col-md-4 col-lg-1">
                              <div class="media">
                                <div class="media-body icon-state mt-1">
                                  <label class="switch">
                                    <input @change="toggleCheckHours('tuesday')" :checked="companyHoursInfo.tuesday.isOn" type="checkbox" ><span class="switch-state"></span>
                                  </label>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 col-lg-6 text-center">
                              <div class="col-lg-5 inline-block">
                                <div class="rounded border" style="background-color: #f3f3f3">
                                  <div class="card-body p-0">
                                    <div class="card-title mt-2 text-center">
                                      <small>Start Time</small>&nbsp;
                                      <small>
                                        <input :disabled="companyHoursInfo.tuesday.disabled" v-model="companyHoursInfo.tuesday.startTime" class="mouseOver" type="time" style="color: #d94f5c">
                                      </small>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              &nbsp;
                              <div class="col-lg-5 inline-block">
                                <div class="rounded border" style="background-color: #f3f3f3">
                                  <div class="card-body p-0">
                                    <div class="card-title mt-2 text-center">
                                      <small>End Time</small>&nbsp;
                                      <small>
                                        <input :disabled="companyHoursInfo.tuesday.disabled" v-model="companyHoursInfo.tuesday.endTime" class="mouseOver" type="time" style="color: #d94f5c">
                                      </small>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Wednesday -->
                            <div class="col-md-4 col-lg-3">
                              <div class="mt-2">
                                <span class="h5 text-muted f-w-600">Wednesday</span>
                              </div>
                            </div>
                            <div class="col-md-6 col-lg-1">
                              <div class="media">
                                <div class="media-body icon-state mt-1">
                                  <label class="switch">
                                    <input @change="toggleCheckHours('wednesday')" :checked="companyHoursInfo.wednesday.isOn" type="checkbox" ><span class="switch-state"></span>
                                  </label>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 col-lg-6 text-center">
                              <div class="col-lg-5 inline-block">
                                <div class="rounded border" style="background-color: #f3f3f3">
                                  <div class="card-body p-0">
                                    <div class="card-title mt-2 text-center">
                                      <small>Start Time</small>&nbsp;
                                      <small>
                                        <input :disabled="companyHoursInfo.wednesday.disabled" v-model="companyHoursInfo.wednesday.startTime" class="mouseOver" type="time" style="color: #d94f5c">
                                      </small>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              &nbsp;
                              <div class="col-lg-5 inline-block">
                                <div class="rounded border" style="background-color: #f3f3f3">
                                  <div class="card-body p-0">
                                    <div class="card-title mt-2 text-center">
                                      <small>End Time</small>&nbsp;
                                      <small>
                                        <input :disabled="companyHoursInfo.wednesday.disabled" v-model="companyHoursInfo.wednesday.endTime" class="mouseOver" type="time" style="color: #d94f5c">
                                      </small>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Thursday -->
                            <div class="col-md-4 col-lg-3">
                              <div class="mt-2">
                                <span class="h5 text-muted f-w-600">Thursday</span>
                              </div>
                            </div>
                            <div class="col-md-4 col-lg-1">
                              <div class="media">
                                <div class="media-body icon-state mt-1">
                                  <label class="switch">
                                    <input @change="toggleCheckHours('thursday')" :checked="companyHoursInfo.thursday.isOn" type="checkbox" ><span class="switch-state"></span>
                                  </label>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 col-lg-6 text-center">
                              <div class="col-lg-5 inline-block">
                                <div class="rounded border" style="background-color: #f3f3f3">
                                  <div class="card-body p-0">
                                    <div class="card-title mt-2 text-center">
                                      <small>Start Time</small>&nbsp;
                                      <small>
                                        <input :disabled="companyHoursInfo.thursday.disabled" v-model="companyHoursInfo.thursday.startTime" class="mouseOver" type="time" style="color: #d94f5c">
                                      </small>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              &nbsp;
                              <div class="col-lg-5 inline-block">
                                <div class="rounded border" style="background-color: #f3f3f3">
                                  <div class="card-body p-0">
                                    <div class="card-title mt-2 text-center">
                                      <small>End Time</small>&nbsp;
                                      <small>
                                        <input :disabled="companyHoursInfo.thursday.disabled" v-model="companyHoursInfo.thursday.endTime" class="mouseOver" type="time" style="color: #d94f5c">
                                      </small>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Friday -->
                            <div class="col-md-4 col-lg-3">
                              <div class="mt-2">
                                <span class="h5 text-muted f-w-600">Friday</span>
                              </div>
                            </div>
                            <div class="col-md-4 col-lg-1">
                              <div class="media">
                                <div class="media-body icon-state mt-1">
                                  <label class="switch">
                                    <input @change="toggleCheckHours('friday')" :checked="companyHoursInfo.friday.isOn" type="checkbox" ><span class="switch-state"></span>
                                  </label>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 col-lg-6 text-center">
                              <div class="col-lg-5 inline-block">
                                <div class="rounded border" style="background-color: #f3f3f3">
                                  <div class="card-body p-0">
                                    <div class="card-title mt-2 text-center">
                                      <small>Start Time</small>&nbsp;
                                      <small>
                                        <input :disabled="companyHoursInfo.friday.disabled" v-model="companyHoursInfo.friday.startTime" class="mouseOver" type="time" style="color: #d94f5c">
                                      </small>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              &nbsp;
                              <div class="col-lg-5 inline-block">
                                <div class="rounded border" style="background-color: #f3f3f3">
                                  <div class="card-body p-0">
                                    <div class="card-title mt-2 text-center">
                                      <small>End Time</small>&nbsp;
                                      <small>
                                        <input :disabled="companyHoursInfo.friday.disabled" v-model="companyHoursInfo.friday.endTime" class="mouseOver" type="time" style="color: #d94f5c">
                                      </small>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- Saturday -->
                            <div class="col-md-4 col-lg-3">
                              <div class="mt-2">
                                <span class="h5 text-muted f-w-600">Saturday</span>
                              </div>
                            </div>
                            <div class="col-md-6 col-lg-1">
                              <div class="media">
                                <div class="media-body icon-state mt-1">
                                  <label class="switch">
                                    <input @change="toggleCheckHours('saturday')" :checked="companyHoursInfo.saturday.isOn" type="checkbox" ><span class="switch-state"></span>
                                  </label>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 col-lg-6 text-center">
                              <div class="col-lg-5 inline-block">
                                <div class="rounded border" style="background-color: #f3f3f3">
                                  <div class="card-body p-0">
                                    <div class="card-title mt-2 text-center">
                                      <small>Start Time</small>&nbsp;
                                      <small>
                                        <input :disabled="companyHoursInfo.saturday.disabled" @change="onChangeEvenBusinessHours($event)" v-model="companyHoursInfo.saturday.startTime" class="mouseOver" type="time" style="color: #d94f5c">
                                      </small>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              &nbsp;
                              <div class="col-lg-5 inline-block">
                                <div class="rounded border" style="background-color: #f3f3f3">
                                  <div class="card-body p-0">
                                    <div class="card-title mt-2 text-center">
                                      <small>End Time</small>&nbsp;
                                      <small>
                                        <input :disabled="companyHoursInfo.saturday.disabled" @change="onChangeEvenBusinessHours($event)" v-model="companyHoursInfo.saturday.endTime" class="mouseOver" type="time" style="color: #d94f5c">
                                      </small>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <Transition>
                        <div class="float-end" v-show="toggleResetOrSave.show">
                          <button class="btn btn-danger mr-2" @click="populateBusinessHours(companyHoursInfo)">Reset</button>
                          <button class="btn btn-primary" @click="saveBusinessHours">Save</button>
                        </div>
                      </Transition>
                    </div>
                    <div class="fade tab-pane" id="pills-delayed" role="tabpanel" aria-labelledby="pills-delayed-tab">
                      <div class="card mb-0">
                        <div class="card-body">
                          <h3 class="card-title pb-2">Monthly Overhead</h3>
                          <div class="row">
                            <div class="col-6">
                              <div class="alert alert-light dark" role="alert">
                                <p class=""><strong>Notice:</strong> Monthly overhead is your estimated monthly expenses that can be used to calculate so you can see your true profits throughout your everyday life.
                                  For history purposes, <strong><i>Buildovate</i></strong>will save your monthly overhead history so you can see historical data in your reporting.</p>
                              </div>
                            </div>
                            <div class="col-6">
                              <CompanyOverheadChart :chartLabels="overheadChart.chartLabels" :seriesData="overheadChart.seriesData "></CompanyOverheadChart>
                            </div>
                          </div>
                          <div class="card-title">
                            <span class="h6">Total Monthly Overhead: </span>
                            <span class="h5 f-w-600"> {{ totalOverHead }}</span>
                            <button class="btn btn-primary float-end btn-sm btn-pill" data-bs-toggle="modal" data-original-title="Monthly Overhead" data-bs-target="#monthlyOverHead" @click="clearModal">New Overhead</button>
                          </div>
                          <div class="table-responsive">
                            <table class="table table-hover">
                              <thead>
                              <tr>
                                <th scope="col">Title/Name</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Action</th>
                              </tr>
                              </thead>
                              <tbody>
                              <tr v-for="(item, i) in companyOverHead">
                                <td>{{ item.expense_name }}</td>
                                <td>{{ formatAmount(parseFloat(item.expense_amount)) }}</td>
                                <td class="">
                                  <button class="btn btn-primary btn-xs btn-pill mr-1" @click="editOverhead(item)" data-bs-toggle="modal" data-bs-target="#monthlyOverHead"> <i class="fa fa-edit"></i> Edit</button>
                                  <button class="btn btn-danger btn-xs btn-pill" @click="deleteOverHead(item)"><i class="icon-trash"></i> Delete</button>
                                </td>
                              </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="fade tab-pane" id="pills-upcoming" role="tabpanel" aria-labelledby="pills-upcoming-tab">
                      <div class="card mb-0">
                        <div class="card-body">
                          <div class="card-title">
                            <span class="h3">Phone Numbers</span>
                          </div>
                          <div class="card-title">
                            <button class="btn btn-primary float-end btn-sm btn-pill" data-bs-toggle="modal" data-original-title="Phone Numbers" data-bs-target="#phoneNumbers" @click="clearModal">New</button>
                          </div>
                          <div class="table-responsive">
                            <table class="table table-hover ">
                              <thead>
                              <tr>
                                <th scope="col">Title/Name</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Action</th>
                              </tr>
                              </thead>
                              <tbody>
                              <tr v-for="number in companyNumber">
                                <td>{{ number.number_title }}</td>
                                <td>{{ formatPhoneNumber(number.company_number) }} <span v-if="number.is_primary == 1" class="badge badge-secondary badge-pill">Primary</span></td>
                                <td class="">
                                  <button class="btn btn-primary btn-xs btn-pill mr-1" @click="editPhoneNumber(number)" data-bs-toggle="modal" data-bs-target="#phoneNumbers"> <i class="fa fa-edit"></i> Edit</button>
                                  <button class="btn btn-danger btn-xs btn-pill" @click="deletePhoneNumber(number)"> <i class="icon-trash"></i> Delete</button>
                                </td>
                              </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="fade tab-pane" id="pills-weekly" role="tabpanel" aria-labelledby="pills-weekly-tab">
                      <div class="card mb-0">
                        <div class="card-body">
                          <div class="card-title">
                            <span class="h3">Emails</span>
                          </div>
                          <div class="card-title">
                            <button class="btn btn-primary float-end btn-sm btn-pill" data-bs-toggle="modal" data-original-title="Phone Numbers" data-bs-target="#emails" @click="clearModal">New</button>
                          </div>
                          <div class="table-responsive">
                            <table class="table table-hover">
                              <thead>
                              <tr>
                                <th scope="col">Title/Name</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Action</th>
                              </tr>
                              </thead>
                              <tbody>
                              <tr v-for="email in companyEmail">
                                <td>{{ email.email_title}}</td>
                                <td>{{ email.company_email }} <span v-if="email.is_primary == 1" class="badge badge-secondary badge-pill">Primary</span></td>
                                <td class="">
                                  <button class="btn btn-primary btn-xs btn-pill mr-1" @click="editEmailData(email)" data-bs-toggle="modal" data-bs-target="#emails"> <i class="fa fa-edit"></i> Edit</button>
                                  <button class="btn btn-danger btn-xs btn-pill" @click="deleteEmail(email)"> <i class="icon-trash"></i> Delete</button>
                                </td>
                              </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="fade tab-pane" id="pills-monthly" role="tabpanel" aria-labelledby="pills-monthly-tab">
                      <div class="card mb-0">
                        <div class="card-body">
                          <div class="card-title">
                            <span class="h3">Locations</span>
                          </div>
                          <div class="card-title">
                            <button class="btn btn-primary float-end btn-sm btn-pill" data-bs-toggle="modal" data-original-title="Locations" data-bs-target="#locations" @click="clearModal">New</button>
                          </div>
                          <div class="table-responsive">
                            <table class="table table-hover">
                              <thead>
                              <tr>
                                <th scope="col">Address</th>
                                <th scope="col">Action</th>
                              </tr>
                              </thead>
                              <tbody>
                              <tr v-for="loc in companyLocation">
                                <td>{{ loc.location_address }} {{ loc.location_street }} {{ loc.location_city }} {{ loc.location_zipcode }} <span v-if="loc.is_primary == 1" class="badge badge-secondary badge-pill">Primary</span></td>
                                <td class="">
                                  <button class="btn btn-primary btn-xs btn-pill mr-1" @click="editLocation(loc)" data-bs-toggle="modal" data-original-title="Locations" data-bs-target="#locations"> <i class="fa fa-edit"></i> Edit</button>
                                  <button class="btn btn-danger btn-xs btn-pill" @click="deleteLocation(loc)"> <i class="icon-trash"></i> Delete</button>
                                </td>
                              </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="fade tab-pane" id="pills-assigned" role="tabpanel" aria-labelledby="pills-assigned-tab">
                      <div class="card mb-0">
                        <div class="card-body">
                          <div class="card-title">
                            <span class="h3">Websites</span>
                          </div>
                          <div class="card-title">
                            <button class="btn btn-primary float-end btn-sm btn-pill" data-bs-toggle="modal" data-original-title="Locations" data-bs-target="#websites" @click="clearModal">New</button>
                          </div>
                          <div class="table-responsive">
                            <table class="table table-hover">
                              <thead>
                              <tr>
                                <th scope="col">Website Name</th>
                                <th scope="col">URL</th>
                                <th scope="col">Action</th>
                              </tr>
                              </thead>
                              <tbody>
                              <tr v-for="website in companyWebsite">
                                <td>{{ website.website_name }}</td>
                                <td>{{ website.company_website }} <span v-if="website.is_primary == 1" class="badge badge-secondary badge-pill">Primary</span></td>
                                <td class="">
                                  <button class="btn btn-primary btn-xs btn-pill mr-1" @click="editWebsite(website)" data-bs-toggle="modal" data-original-title="Locations" data-bs-target="#websites"> <i class="fa fa-edit"></i> Edit</button>
                                  <button class="btn btn-danger btn-xs btn-pill" @click="deleteWebsite(website)"> <i class="icon-trash"></i> Delete</button>
                                </td>
                              </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="fade tab-pane" id="pills-tasks" role="tabpanel" aria-labelledby="pills-tasks-tab">
                      <div class="card mb-0">
                        <div class="card-body">
                          <div class="card-title">
                            <span class="h3">Social Media</span>
                          </div>
                          <div class="row mt-5">
                            <div class="col-md-1">
                              <div class="mt-2 ml-2">
                                <img :src="imageUrl.instagram" alt="instagram" style="height: 3.75rem; width: 3.75rem">
                              </div>
                            </div>
                            <div class="col-md-11">
                              <div class="m-form__group">
                                <label class="form-label h5">Instagram</label>
                                <div class="input-group">
                                  <span id="instaUrl" class="input-group-text text-muted">URL:</span>
                                  <input v-model="socMed.instagram" id="instagram" class="form-control" type="text" placeholder="Paste your business instagram profile url here...">
                                  <span id="saveInsta" class="input-group-text text-muted" @click="saveOrUpdateSocMed(socMed.instagram, 'instagram')"><button>Save</button></span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <hr>
                          <div class="row mt-5">
                            <div class="col-md-1">
                              <div class="mt-2 ml-2">
                                <img :src="imageUrl.facebook" alt="facebook" style="height: 3.75rem; width: 3.75rem">
                              </div>
                            </div>
                            <div class="col-md-11">
                              <div class="m-form__group">
                                <label class="form-label h5">Facebook</label>
                                <div class="input-group">
                                  <span id="fbUrl" class="input-group-text text-muted">URL:</span>
                                  <input v-model="socMed.facebook" id="facebook" class="form-control" type="text" placeholder="Paste your business facebook profile url here...">
                                  <span id="saveFb" class="input-group-text text-muted" @click="saveOrUpdateSocMed(socMed.facebook, 'facebook')"><button>Save</button></span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <hr>
                          <div class="row mt-5">
                            <div class="col-md-1">
                              <div class="mt-2 ml-2">
                                <img :src="imageUrl.yelp" alt="yelp" style="height: 3.75rem; width: 3.75rem">
                              </div>
                            </div>
                            <div class="col-md-11">
                              <div class="m-form__group">
                                <label class="form-label h5">Yelp</label>
                                <div class="input-group">
                                  <span id="yelpUrl" class="input-group-text text-muted">URL:</span>
                                  <input v-model="socMed.yelp" id="yelp" class="form-control" type="text" placeholder="Paste your business yelp profile url here...">
                                  <span id="saveYelp" class="input-group-text text-muted" @click="saveOrUpdateSocMed(socMed.yelp, 'yelp')"><button>Save</button></span>
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
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modals -->
  <div class="modal fade" id="monthlyOverHead" tabindex="-1" role="dialog" aria-labelledby="monthlyOverHead" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="">Company Overhead Number</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" @submit.prevent="saveMonthlyOverHead" method="POST">
          <input type="text" hidden v-model="companyOverHeadForm.overHeadHiddenId">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="input-group mb-2">
                  <span class="input-group-text text-muted">Title:</span>
                  <input id="over-head-title" v-model="companyOverHeadForm.overHeadTitle" class="form-control" type="text" placeholder="Title...">
                </div>
                <div class="input-group">
                  <span class="input-group-text text-muted">Overhead Amount:</span>
                  <input id="over-head-amount" v-model="companyOverHeadForm.OverHeadAmount" class="form-control" type="number" placeholder="Amount...">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-secondary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="phoneNumbers" tabindex="-1" role="dialog" aria-labelledby="phoneNumbers" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="">Company Phone Number</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" @submit.prevent="savePhoneNumber" method="POST">
          <input type="text" hidden v-model="companyPhoneNumbers.phoneNumberHiddenId">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="input-group mb-2">
                  <span class="input-group-text text-muted">Title:</span>
                  <input id="phone-number-title" v-model="companyPhoneNumbers.phoneNumberTitle" class="form-control" type="text" placeholder="Title...">
                </div>
                <div class="input-group mb-2">
                  <span class="input-group-text text-muted">Phone Number:</span>
                  <input id="phone-number" v-model="companyPhoneNumbers.phoneNumber" class="form-control" type="number" placeholder="Number...">
                </div>
                <div class="input-group">
                  <span class="input-group-text text-muted">Make as Primary:</span>
                  <div class="form-control">
                    <label class="d-block" for="is-primary">
                      <input :checked="companyPhoneNumbers.phoneNumberIsPrimary" @change="toggleIsPrimary('phonenumber')" class="checkbox_animated" id="is-primary" type="checkbox">
                      Is Primary?
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-secondary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="emails" tabindex="-1" role="dialog" aria-labelledby="emails" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="">Company Email</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" @submit.prevent="saveEmail" method="POST">
          <input type="text" hidden v-model="companyEmails.emailHiddenId">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="input-group mb-2">
                  <span class="input-group-text text-muted">Title:</span>
                  <input id="company-title" v-model="companyEmails.emailTitle" class="form-control" type="text" placeholder="Title...">
                </div>
                <div class="input-group mb-2">
                  <span class="input-group-text text-muted">Email:</span>
                  <input id="company-email" v-model="companyEmails.email" class="form-control" type="email" placeholder="Email...">
                </div>
                <div class="input-group">
                  <span class="input-group-text text-muted">Make as Primary:</span>
                  <div class="form-control">
                    <label class="d-block" for="is-primary">
                      <input :checked="companyEmails.emailIsPrimary" @change="toggleIsPrimary('email')" class="checkbox_animated" id="is-primary-email" type="checkbox">
                      Is Primary?
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-secondary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="locations" tabindex="-1" role="dialog" aria-labelledby="locations" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="">Company Location</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" @submit.prevent="saveAddressData" method="POST">
          <input type="text" hidden v-model="companyLocationInfo.addressHiddenId">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="input-group mb-2">
                  <span class="input-group-text text-muted">Address:</span>
                  <input id="company-address" v-model="companyLocationInfo.companyAddress" class="form-control" type="text" placeholder="Address...">
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group mb-2">
                  <span class="input-group-text text-muted">Street:</span>
                  <input id="company-street" v-model="companyLocationInfo.companyStreet" class="form-control" type="text" placeholder="Street...">
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group mb-2">
                  <span class="input-group-text text-muted">City:</span>
                  <input id="company-city" v-model="companyLocationInfo.companyCity" class="form-control" type="text" placeholder="City...">
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group mb-2">
                  <span class="input-group-text text-muted">Zipcode:</span>
                  <input id="company-zip" v-model="companyLocationInfo.companyZip" class="form-control" type="number" placeholder="Zipcode...">
                </div>
              </div>
              <div class="col-md-12">
                <div class="input-group">
                  <span class="input-group-text text-muted">Make as Primary:</span>
                  <div class="form-control">
                    <label class="d-block" for="is-primary-location">
                      <input :checked="companyLocationInfo.addressIsPrimary" @change="toggleIsPrimary('location')" class="checkbox_animated" id="is-primary-location" type="checkbox">
                      Is Primary?
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-secondary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="websites" tabindex="-1" role="dialog" aria-labelledby="locations" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="">Company Website</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" @submit.prevent="saveWebsiteData" method="POST">
          <input type="text" hidden v-model="companyWebsiteInfo.companyWebHiddenId">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="input-group mb-2">
                  <span class="input-group-text text-muted">Web Name:</span>
                  <input id="company-web-name" v-model="companyWebsiteInfo.companyWebName" class="form-control" type="text" placeholder="Name...">
                </div>
              </div>
              <div class="col-md-12">
                <div class="input-group mb-2">
                  <span class="input-group-text text-muted">Web Address:</span>
                  <input id="company-web-url" v-model="companyWebsiteInfo.companyWebUrl" class="form-control" type="text" placeholder="Url...">
                </div>
              </div>
              <div class="col-md-12">
                <div class="input-group">
                  <span class="input-group-text text-muted">Make as Primary:</span>
                  <div class="form-control">
                    <label class="d-block" for="is-primary-location">
                      <input :checked="companyWebsiteInfo.companyWebIsPrimary" @change="toggleIsPrimary('website')" class="checkbox_animated" id="is-primary-website" type="checkbox">
                      Is Primary?
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-secondary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<style>
input[type="file"] {
  display: none;
}
</style>

<script>
import { router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import axios from 'axios';
import checkUrl from 'is-url-http';
import { toast } from 'vue3-toastify';
import ImageCropper from '@/components/ImageCropper.vue';
import CompanyOverheadChart from "@/components/charts/CompanyOverheadChart.vue";

export default {
  props: [
    'companyDetails',
    'timezone',
    'dateFormat',
    'timeFormat',
    'daysOfWeek',
    'companyOverHead',
    'companyNumber',
    'companyEmail',
    'companyLocation',
    'companyWebsite',
    'socialMedia',
    'companyHours'
  ],
  components:{
    ImageCropper,
    CompanyOverheadChart,
  },
  data() {
    return {
      imageCropperOptions:{
        aspectRatio:16 / 9,//1
        width: 150, //172,//258,
        height: 50,//60,//90,
        defaultImage: (this.companyDetails.logo!='') ? '/uploads/logos/'+ this.companyDetails.logo : ''
      },
      imageUrl: {
        instagram: window.location.origin + '/assets/images/instagram_icon.png',
        facebook: window.location.origin + '/assets/images/fb_icon.png',
        yelp: window.location.origin + '/assets/images/yelp_icon.png'
      },
      companyBaseInfo: {
        name: '',
        industry: '',
        license: '',
        timezone: '',
        dateFormatInfo: '',
        timeFormatInfo: '',
        dayWorkWeek: '',
        logo:'',
        logo_email_message:'',
        logo_client_portal:'',
        logo_all_pdfs:'',
        logo_financials:'',
        federalTaxId: ''
      },
      companyOverHeadForm: {
        overHeadTitle: '',
        OverHeadAmount: '',
        overHeadHiddenId: ''
      },
      companyPhoneNumbers: {
        phoneNumberTitle: '',
        phoneNumber: '',
        phoneNumberIsPrimary: false,
        phoneNumberHiddenId: '',
      },
      companyEmails: {
        emailTitle: '',
        email: '',
        emailHiddenId: '',
        emailIsPrimary: false
      },
      companyLocationInfo: {
        companyAddress: '',
        companyStreet: '',
        companyCity: '',
        companyZip: '',
        addressIsPrimary: false,
        addressHiddenId: ''
      },
      companyWebsiteInfo: {
        companyWebName: '',
        companyWebUrl: '',
        companyWebIsPrimary: false,
        companyWebHiddenId: ''
      },
      socMed: {
        instagram : '',
        facebook: '',
        yelp: ''
      },
      companyHoursInfo: {
        sunday: {
          isOn: false,
          startTime: '',
          endTime: '',
          entryId: '',
          companyId: '',
          disabled: 1
        },
        monday: {
          isOn: false,
          startTime: '',
          endTime: '',
          entryId: '',
          companyId: '',
          disabled: 1
        },
        tuesday: {
          isOn: '',
          startTime: '',
          endTime: '',
          entryId: '',
          companyId: '',
          disabled: 1
        },
        wednesday: {
          isOn: '',
          startTime: '',
          endTime: '',
          entryId: '',
          companyId: '',
          disabled: 1
        },
        thursday: {
          isOn: '',
          startTime: '',
          endTime: '',
          entryId: '',
          companyId: '',
          disabled: 1
        },
        friday: {
          isOn: '',
          startTime: '',
          endTime: '',
          entryId: '',
          companyId: '',
          disabled: 1
        },
        saturday: {
          isOn: false,
          startTime: '',
          endTime: '',
          entryId: '',
          companyId: '',
          disabled: 1
        }
      },
      toggleResetOrSave: {
        show: true
      },
      file: '',
      overheadChart:{
        seriesData:[],
        chartLabels:[]
      }
    }
  },
  mounted() {
    const expenseNames = this.companyOverHead.map(item => item.expense_name);
    const expenseAmounts = this.companyOverHead.map(item => parseFloat(item.expense_amount));
    this.overheadChart.chartLabels = expenseNames;
    this.overheadChart.seriesData = expenseAmounts;

    this.populateBusinessHours(this.companyHoursInfo)
    this.companyBaseInfo.name = this.companyDetails.company_name
    this.companyBaseInfo.industry = this.companyDetails.industry
    this.companyBaseInfo.license = this.companyDetails.license_number
    this.companyBaseInfo.timezone = this.companyDetails.timezone
    this.companyBaseInfo.dateFormatInfo = this.companyDetails.date_format
    this.companyBaseInfo.timeFormatInfo = this.companyDetails.time_format
    this.companyBaseInfo.dayWorkWeek = this.companyDetails.first_day
    this.companyBaseInfo.federalTaxId = this.companyDetails.federal_tax_id;
    // this.companyBaseInfo.logo = this.companyDetails.logo
    this.companyBaseInfo.logo = this.companyDetails.company_name
    this.companyBaseInfo.logo_email_message = (this.companyDetails.logo_email_message=='1') ? true : false
    this.companyBaseInfo.logo_client_portal = (this.companyDetails.logo_client_portal=='1') ? true : false
    this.companyBaseInfo.logo_all_pdfs = (this.companyDetails.logo_all_pdfs=='1') ? true : false
    this.companyBaseInfo.logo_financials = (this.companyDetails.logo_financials=='1') ? true : false
    let insta = ''
    let fb = ''
    let yelp = ''

    $.each(this.socialMedia, function(k, val) {
      if (val.key == 'instagram') {
        insta = val.social_media_url
      }

      if (val.key == 'facebook') {
        fb = val.social_media_url
      }

      if (val.key == 'yelp') {
        yelp = val.social_media_url
      }
    })

    this.socMed.facebook = fb
    this.socMed.instagram = insta
    this.socMed.yelp = yelp


    $('#saveInsta').hide()
    $('#saveFb').hide()
    $('#saveYelp').hide()

    $('#instagram').on('focus', function() {
      $(this).on('input', function() {
        if($(this).val().length > 0) {
          $('#saveInsta').show(function (){
            $(this).addClass('green border-color')
          })
        }else{
          $('#saveInsta').hide()
        }
      })
      $(this).addClass('border-color')
      $('#instaUrl').addClass('green border-color')
    });

    $('#instagram').on('focusout', function() {
      if ($(this).val() === '' ) {
        $(this).removeClass('border-color')
        $('#instaUrl').removeClass('green border-color')
      }
    });

    $('#facebook').on('focus', function() {
      $(this).on('input', function() {
        if($(this).val().length > 0) {
          $('#saveFb').show(function (){
            $(this).addClass('green border-color')
          })
        }else{
          $('#saveFb').hide()
        }
      })
      $(this).addClass('border-color')
      $('#fbUrl').addClass('green border-color')
    });

    $('#facebook').on('focusout', function() {
      if ($(this).val() === '' ) {
        $(this).removeClass('border-color')
        $('#fbUrl').removeClass('green border-color')
      }
    });

    $('#yelp').on('focus', function() {
      $(this).on('input', function() {
        if($(this).val().length > 0) {
          $('#saveYelp').show(function (){
            $(this).addClass('green border-color')
          })
        }else{
          $('#saveYelp').hide()
        }
      })
      $(this).addClass('border-color')
      $('#yelpUrl').addClass('green border-color')
    });

    $('#yelp').on('focusout', function() {
      if ($(this).val() === '' ) {
        $(this).removeClass('border-color')
        $('#yelpUrl').removeClass('green border-color')
      }
    });
  },
  computed: {
    totalOverHead() {
      let total = 0
      $.each(this.companyOverHead, function(key, value) {
        $.each(value, function(k, val) {
          if (k === 'expense_amount') {
            total += parseFloat(val)
          }
        })
      })
      return this.formatAmount(total)
    },
    // toggleIsPrimary() {
    //   this.companyPhoneNumbers.phoneNumberIsPrimary = !this.companyPhoneNumbers.phoneNumberIsPrimary
    // }
  },
  methods: {
    getCroppedImage(file){
      this.companyBaseInfo.logo = file;
      // document.getElementById('company_logo').src = URL.createObjectURL(file);
    },
    copyToAll: function(monday) {
      // console.log(this.companyHoursInfo)
      let companyBusiness = this.companyHoursInfo
      $.each(companyBusiness, function(key, value) {
        if (key != 'monday') {
            value.isOn = companyBusiness.monday.isOn
            value.startTime = companyBusiness.monday.startTime
            value.endTime = companyBusiness.monday.endTime
            value.disabled = companyBusiness.monday.disabled
          // $.each(value, function(k, v) {
          //   console.log(v)
          // })
        }
      })
    },
    saveBasicInfo: function() {

      if (this.validateRequiredFields(this.companyBaseInfo) > 0) {
        Swal.fire({
          text: 'Fields are required!!!',
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: "Close",
          customClass: {
            confirmButton: "btn btn-success"
          }
        });
      } else {
        let formData = this.companyBaseInfo;
        formData.file = this.file;
        axios.post('details/save/basic-info', formData, { headers: { 'Content-Type': 'multipart/form-data' } })
            .then((result) => {
              if (result.data.status) {
                Swal.fire({
                  text: result.data.message,
                  icon: "success",
                  buttonsStyling: false,
                  confirmButtonText: "Close",
                  customClass: {
                    confirmButton: "btn btn-success"
                  }
                })
                
                router.reload();

                // document.getElementById('company_logo').src = URL.createObjectURL(this.companyBaseInfo.logo);
                document.getElementById('company_logo').innerText = this.companyBaseInfo.name;
              }
            })
      }
    },
    resetCompanyBaseInfo: function() {

      let formData = this.companyBaseInfo
      let dBData = this.companyDetails

      let countVal = 0
      let countFormField = 0

      $.each(formData, function(key, value) {
        countFormField++
        $.each(dBData, function(k, v) {
            if (value === v) {
              countVal++
            }
        })
      })

      if (countVal == countFormField) {
        toast.info('No changes yet!!!')
      } else {
        this.companyBaseInfo.name = this.companyDetails.company_name
        this.companyBaseInfo.industry = this.companyDetails.industry
        this.companyBaseInfo.license = this.companyDetails.license_number
        this.companyBaseInfo.timezone = this.companyDetails.timezone
        this.companyBaseInfo.dateFormatInfo = this.companyDetails.date_format
        this.companyBaseInfo.timeFormatInfo = this.companyDetails.time_format
        this.companyBaseInfo.dayWorkWeek = this.companyDetails.first_day
        this.file = '';
      }

    },
    saveMonthlyOverHead: function() {

      if (this.validateRequiredFields(this.companyOverHeadForm, ['overHeadHiddenId']) > 0) {
        Swal.fire({
          text: 'Fields are required!!!',
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: "Close",
          customClass: {
            confirmButton: "btn btn-success"
          }
        });
      } else {
        axios.post('details/overhead', this.companyOverHeadForm)
            .then((result) => {
              if (result.data.status) {
                Swal.fire({
                  text: result.data.message,
                  icon: "success",
                  buttonsStyling: false,
                  confirmButtonText: "Close",
                  customClass: {
                    confirmButton: "btn btn-success"
                  }
                }).then(function(res) {
                  if (res.isConfirmed) {
                    $('#over-head-title').val('')
                    $('#over-head-amount').val('')
                    $('#monthlyOverHead').modal('hide')
                    $(".modal-backdrop").hide();
                  }
                })
                router.reload()
              }
            })
      }
    },
    deleteOverHead: function(item) {
      Swal.fire({
        html: "Delete <strong>"+item.expense_name+"</strong>?",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        customClass: {
          confirmButton: "btn btn-danger",
          cancelButton: "btn btn-active-light"
        }
      }).then(function(res) {
        if (res.isConfirmed) {
          axios.post('details/delete/overhead', item)
          router.reload()
        }
      })
    },
    editOverhead: function(item) {
      this.companyOverHeadForm.overHeadTitle = item.expense_name
      this.companyOverHeadForm.OverHeadAmount = parseFloat(item.expense_amount)
      this.companyOverHeadForm.overHeadHiddenId = item.company_monthly_overhead_id
      router.reload()
    },
    clearModal: function() {
      this.companyOverHeadForm.overHeadTitle = ''
      this.companyOverHeadForm.OverHeadAmount = ''
      this.companyOverHeadForm.overHeadHiddenId = ''

      this.companyPhoneNumbers.phoneNumberTitle = ''
      this.companyPhoneNumbers.phoneNumber = ''
      this.companyPhoneNumbers.phoneNumberIsPrimary = 0
      this.companyPhoneNumbers.phoneNumberHiddenId = ''

      this.companyEmails.emailTitle = ''
      this.companyEmails.email = ''
      this.companyEmails.emailHiddenId = ''
      this.companyEmails.emailIsPrimary = 0

      this.companyLocationInfo.companyAddress = ''
      this.companyLocationInfo.companyStreet = ''
      this.companyLocationInfo.companyStreet = ''
      this.companyLocationInfo.companyZip = ''
      this.companyLocationInfo.addressHiddenId = ''
      this.companyLocationInfo.addressIsPrimary = 0

      this.companyWebsite.companyWebName = ''
      this.companyWebsite.companyWebUrl = ''
      this.companyWebsite.companyWebIsPrimary = 0
      this.companyWebsite.companyWebHiddenId = ''
    },
    savePhoneNumber: function() {
      if (this.validateRequiredFields(this.companyPhoneNumbers, ['phoneNumberHiddenId', 'phoneNumberIsPrimary']) > 0) {
        Swal.fire({
          text: 'Fields are required!!!',
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: "Close",
          customClass: {
            confirmButton: "btn btn-success"
          }
        });
      } else {
        axios.post('details/phone-number', this.companyPhoneNumbers)
            .then((result) => {
              if (result.data.status) {
                Swal.fire({
                  text: result.data.message,
                  icon: "success",
                  buttonsStyling: false,
                  confirmButtonText: "Close",
                  customClass: {
                    confirmButton: "btn btn-success"
                  }
                }).then(function(res) {
                  if (res.isConfirmed) {
                    $('#phone-number-title').val('')
                    $('#phone-number').val('')
                    // $('#is-primary').prop('checked', false)
                    $('#phoneNumbers').modal('hide')
                    $(".modal-backdrop").hide();
                  }
                })
                router.reload()
              }
            })
      }
    },
    editPhoneNumber:function(number) {
      this.companyPhoneNumbers.phoneNumberTitle = number.number_title
      this.companyPhoneNumbers.phoneNumber = number.company_number
      this.companyPhoneNumbers.phoneNumberIsPrimary = number.is_primary
      this.companyPhoneNumbers.phoneNumberHiddenId = number.company_number_id
    },
    deletePhoneNumber: function(number) {
      Swal.fire({
        html: "Delete <strong>"+number.company_number+"</strong>?",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        customClass: {
          confirmButton: "btn btn-danger",
          cancelButton: "btn btn-active-light"
        }
      }).then(function(res) {
        if (res.isConfirmed) {
          axios.post('details/delete/phone-number', number)
          router.reload()
        }
      })
    },
    saveEmail: function() {
      if (this.validateRequiredFields(this.companyEmails, ['emailHiddenId', 'emailIsPrimary']) > 0) {
        Swal.fire({
          text: 'Fields are required!!!',
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: "Close",
          customClass: {
            confirmButton: "btn btn-success"
          }
        });
      } else {
        axios.post('details/save/email', this.companyEmails)
            .then((result) => {
              if (result.data.status) {
                Swal.fire({
                  text: result.data.message,
                  icon: "success",
                  buttonsStyling: false,
                  confirmButtonText: "Close",
                  customClass: {
                    confirmButton: "btn btn-success"
                  }
                }).then(function(res) {
                  if (res.isConfirmed) {
                    $('#company-title').val('')
                    $('#company-email').val('')
                    $('#is-primary-email').prop('checked', false)
                    $('#emails').modal('hide')
                    $(".modal-backdrop").hide();
                  }
                })
                router.reload()
              }
            })
      }
    },
    editEmailData: function(email) {
      this.companyEmails.emailTitle = email.email_title
      this.companyEmails.email = email.company_email
      this.companyEmails.emailHiddenId = email.company_email_id
      this.companyEmails.emailIsPrimary = email.is_primary
    },
    deleteEmail: function(email) {
      Swal.fire({
        html: "Delete <strong>"+email.company_email+"</strong>?",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        customClass: {
          confirmButton: "btn btn-danger",
          cancelButton: "btn btn-active-light"
        }
      }).then(function(res) {
        if (res.isConfirmed) {
          axios.post('details/delete/email', email)
          router.reload()
        }
      })
    },
    saveAddressData: function() {
      if (this.validateRequiredFields(this.companyLocationInfo, ['addressHiddenId', 'addressIsPrimary']) > 0) {
        Swal.fire({
          text: 'Fields are required!!!',
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: "Close",
          customClass: {
            confirmButton: "btn btn-success"
          }
        });
      } else {
        axios.post('details/save/address', this.companyLocationInfo)
            .then((result) => {
              if (result.data.status) {
                Swal.fire({
                  text: result.data.message,
                  icon: "success",
                  buttonsStyling: false,
                  confirmButtonText: "Close",
                  customClass: {
                    confirmButton: "btn btn-success"
                  }
                }).then(function(res) {
                  if (res.isConfirmed) {
                    $('#company-address').val('')
                    $('#company-street').val('')
                    $('#company-city').val('')
                    $('#company-zip').val('')
                    $('#is-primary-location').prop('checked', false)
                    $('#locations').modal('hide')
                    $(".modal-backdrop").hide();
                  }
                })
                router.reload()
              }
            })
      }
    },
    editLocation: function(location) {
      this.companyLocationInfo.companyAddress = location.location_address
      this.companyLocationInfo.companyStreet = location.location_street
      this.companyLocationInfo.companyCity = location.location_city
      this.companyLocationInfo.companyZip = location.location_zipcode
      this.companyLocationInfo.addressIsPrimary = location.is_primary
      this.companyLocationInfo.addressHiddenId = location.company_location_id
    },
    deleteLocation: function(location) {
      Swal.fire({
        html: "Delete <strong>"+location.location_address+' '+location.location_street+' '+location.location_city+' '+location.location_zipcode+"</strong>?",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        customClass: {
          confirmButton: "btn btn-danger",
          cancelButton: "btn btn-active-light"
        }
      }).then(function(res) {
        if (res.isConfirmed) {
          axios.post('details/delete/address', location)
          router.reload()
        }
      })
    },
    saveWebsiteData: function() {
      if (this.validateRequiredFields(this.companyWebsiteInfo, ['companyWebHiddenId', 'companyWebIsPrimary']) > 0) {
        Swal.fire({
          text: 'Fields are required!!!',
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: "Close",
          customClass: {
            confirmButton: "btn btn-success"
          }
        });
      } else {
        axios.post('details/save/website', this.companyWebsiteInfo)
            .then((result) => {
              if (result.data.status) {
                Swal.fire({
                  text: result.data.message,
                  icon: "success",
                  buttonsStyling: false,
                  confirmButtonText: "Close",
                  customClass: {
                    confirmButton: "btn btn-success"
                  }
                }).then(function(res) {
                  if (res.isConfirmed) {
                    $('#company-web-name').val('')
                    $('#company-web-url').val('')
                    $('#is-primary-website').prop('checked', false)
                    $('#websites').modal('hide')
                    $(".modal-backdrop").hide();
                  }
                })
                router.reload()
              }
            })
      }
    },
    editWebsite: function(web) {
      this.companyWebsiteInfo.companyWebName = web.website_name
      this.companyWebsiteInfo.companyWebUrl = web.company_website
      this.companyWebsiteInfo.companyWebIsPrimary = web.is_primary
      this.companyWebsiteInfo.companyWebHiddenId = web.company_website_id
    },
    deleteWebsite: function(web) {
      Swal.fire({
        html: "Delete <strong>"+web.website_name+"</strong>?",
        icon: "warning",
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        customClass: {
          confirmButton: "btn btn-danger",
          cancelButton: "btn btn-active-light"
        }
      }).then(function(res) {
        if (res.isConfirmed) {
          axios.post('details/delete/website', web)
          router.reload()
        }
      })
    },
    formatAmount: function(amount) {
      return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD', // Change this to your desired currency code if not USD
      }).format(amount);
    },
    saveOrUpdateSocMed: function(val, key) {
      const data = {
        value: val,
        key: key
      }

      if (!checkUrl(val)) {
        Swal.fire({
          html:"<strong>"+val+"</strong> is not a valid url!!!",
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: "Close",
          customClass: {
            confirmButton: "btn btn-success"
          }
        });
      } else {
        axios.post('details/save/social-media-url', data)
            .then((result) => {
              if (result.data.status) {
                toast.success('Url has been saved!!!')

                if (key == 'instagram') {
                  $('#saveInsta').hide()
                  $('#instagram').removeClass('border-color')
                  $('#instaUrl').removeClass('green border-color')
                }

                if (key == 'facebook') {
                  $('#saveFb').hide()
                  $('#facebook').removeClass('border-color')
                  $('#fbUrl').removeClass('green border-color')
                }

                if (key == 'yelp') {
                  $('#saveYelp').hide()
                  $('#yelp').removeClass('border-color')
                  $('#yelpUrl').removeClass('green border-color')
                }
              }
            })
      }
    },
    populateBusinessHours: function(obj) {

      let dbData = [];

      $.each(this.companyHours, function(dbKey, dbVal) {
        dbData.push(dbVal)
      })

      $.each(dbData, function(key, val) {
        $.each(obj, function(k, v) {
          if (val.day == k) {
            this.isOn = val.is_active
            this.startTime = val.start_time
            this.endTime = val.end_time
            this.entryId = val.company_hours_id
            this.companyId = val.company_id

            if(val.is_active == 0) {
              this.disabled = 1
            } else {
              this.disabled = 0
            }
          }
        })
      })
      // this.toggleResetOrSave.show = !this.toggleResetOrSave.show
    },
    onChangeEvenBusinessHours: function(event,origVal) {
      // this.toggleResetOrSave.show = !this.toggleResetOrSave.show
    },
    saveBusinessHours: function() {
    //   let firstArray = this.companyHoursInfo
    //   let secondArray = this.companyHours
    //
    //   let newDbArray = []
    //
    //   let countChanges = 0
    //`
    //   $.each(secondArray, function(key, val) {
    //     newDbArray.push(val)
    //   })
    //
    //   $.each(newDbArray, function(key, val) {
    //     $.each(firstArray, function(k, v) {
    //         if (v.startTime === val.start_time || v.endTime === val.end_time || v.isOn === val.is_active) {
    //           countChanges++
    //         }
    //     })
    //   })

      axios.post('details/update/business-hours', this.companyHoursInfo)
          .then((result) => {
            if(result.data.status) {
              Swal.fire({
                text: "Business hours successfully updated!!!",
                icon: "success",
                showCancelButton: false,
                buttonsStyling: false,
                confirmButtonText: "OK",
                customClass: {
                  confirmButton: "btn btn-success",
                }
              })
              router.reload()
            }
          })
    },
    toggleCheckHours: function(key) {
      switch(key) {
        case 'saturday':
          this.companyHoursInfo.saturday.isOn = !this.companyHoursInfo.saturday.isOn
          // this.toggleResetOrSave.show = !this.toggleResetOrSave.show
          this.companyHoursInfo.saturday.disabled = !this.companyHoursInfo.saturday.disabled
              break
        case 'sunday':
          this.companyHoursInfo.sunday.isOn = !this.companyHoursInfo.sunday.isOn
          // this.toggleResetOrSave.show = !this.toggleResetOrSave.show
          this.companyHoursInfo.sunday.disabled = !this.companyHoursInfo.sunday.disabled
          break
        case 'monday':
          this.companyHoursInfo.monday.isOn = !this.companyHoursInfo.monday.isOn
          // this.toggleResetOrSave.show = !this.toggleResetOrSave.show
          this.companyHoursInfo.monday.disabled = !this.companyHoursInfo.monday.disabled
          break
        case 'tuesday':
          this.companyHoursInfo.tuesday.isOn = !this.companyHoursInfo.tuesday.isOn
          // this.toggleResetOrSave.show = !this.toggleResetOrSave.show
          this.companyHoursInfo.tuesday.disabled = !this.companyHoursInfo.tuesday.disabled
          break
        case 'wednesday':
          this.companyHoursInfo.wednesday.isOn = !this.companyHoursInfo.wednesday.isOn
          // this.toggleResetOrSave.show = !this.toggleResetOrSave.show
          this.companyHoursInfo.wednesday.disabled = !this.companyHoursInfo.wednesday.disabled
          break
        case 'thursday':
          this.companyHoursInfo.thursday.isOn = !this.companyHoursInfo.thursday.isOn
          // this.toggleResetOrSave.show = !this.toggleResetOrSave.show
          this.companyHoursInfo.thursday.disabled = !this.companyHoursInfo.thursday.disabled
          break
        case 'friday':
          this.companyHoursInfo.friday.isOn = !this.companyHoursInfo.friday.isOn
          // this.toggleResetOrSave.show = !this.toggleResetOrSave.show
          this.companyHoursInfo.friday.disabled = !this.companyHoursInfo.friday.disabled
          break
      }
    },
    formatPhoneNumber: function(phoneNumber) {
      // Remove all non-digit characters from the string
      const cleaned = phoneNumber.replace(/\D/g, '');

      // Extract the different parts of the phone number
      const areaCode = cleaned.substring(0, 3);
      const prefix = cleaned.substring(3, 6);
      const lineNumber = cleaned.substring(6, 10);

      // Format the phone number with parentheses and hyphen
      return `(${areaCode}) ${prefix}-${lineNumber}`;
    },
    validateRequiredFields: function(fields, exceptKey) {
      let countError = 0;
      $.each(fields, function(key, value) {
        let i = $.inArray(key, exceptKey)
        if (i == -1 && value.length === 0) {
          console.log(key, value)
          countError++
        }
      })
      return countError
    },
    toggleIsPrimary: function(key) {
      switch (key) {
        case 'phonenumber':
          this.companyPhoneNumbers.phoneNumberIsPrimary = !this.companyPhoneNumbers.phoneNumberIsPrimary
          break;
        case 'email':
          this.companyEmails.emailIsPrimary = !this.companyEmails.emailIsPrimary
          break;
        case 'location':
          this.companyLocationInfo.addressIsPrimary = !this.companyLocationInfo.addressIsPrimary
          break
        case 'website':
          this.companyWebsiteInfo.companyWebIsPrimary = !this.companyWebsiteInfo.companyWebIsPrimary
          break
      }
    },
    handleFile: function(event) {
      const allowed_file_types = [
        "image/jpeg",
        "image/png",
        "application/pdf",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        "application/msword"
      ];
      const file_type = event.target.files[0]["type"];
      // console.log("file_type", file_type)

      if (!allowed_file_types.includes(file_type)) {
        Swal.fire(
          "Error",
          "Invalid file format. Only jpg, jpeg, jfif, pjpeg, pjp, png, docx, doc, and pdf are allowed.",
          "error"
        );
        return;
      }

      const size = event.target.files[0]["size"];
      if (size > 5242880) {
        Swal.fire("Error", "File size should not be greater than 5MB.", "error");
        return;
      }
      this.file = event.target.files[0];
    }
  }
}
</script>

