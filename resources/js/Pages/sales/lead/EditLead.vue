<template>
  <div class="page-header p-3">
    <div class="row">
      <div class="col-sm-6">
        <Breadcrumb />
      </div>
      <div class="col-sm-6">
        <div class="d-flex align-items-center justify-content-between" style="width: auto; float: right">
          <a class="btn btn-danger" style="height: 35px !important" @click="handleDeleteLead">DELETE</a>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid" style="background-color: #f5f7fb">
    <div class="edit-profile">
      <div class="row">
        <div class="col-xl-4">
          <div class="card b-primary-v2">
            <div class="card-header pb-0 d-flex justify-content-between">
              <h4 class="card-title mb-0">Customer Details</h4>
              <a
                class="btn btn-outline-danger"
                style="height: 35px !important"
                v-if="customerFieldsDisabled"
                @click="handleEditCustomer"
                >EDIT</a
              >
              <a class="btn btn-outline-primary" style="height: 35px !important" v-else @click="handleSelectCustomer"
                >SELECT</a
              >
            </div>
            <div class="card-body">
              <form method="POST">
                <div class="mb-3 row">
                  <div class="col-sm-6 col-md-6">
                    <div>
                      <label class="form-label f-w-600">First Name</label>
                      <input
                        class="form-control b-primary-v2"
                        type="text"
                        placeholder="..."
                        name="first_name"
                        v-model="form.first_name"
                        @input="handleInput"
                        required
                        :disabled="customerFieldsDisabled"
                      />
                      <div class="text-danger" v-if="form.errors.first_name">{{ form.errors.first_name }}</div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-6">
                    <div>
                      <label class="form-label f-w-600">Last Name</label>
                      <input
                        class="form-control b-primary-v2"
                        type="text"
                        placeholder="..."
                        name="last_name"
                        v-model="form.last_name"
                        @input="handleInput"
                        required
                        :disabled="customerFieldsDisabled"
                      />
                      <div class="text-danger" v-if="form.errors.last_name">{{ form.errors.last_name }}</div>
                    </div>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label f-w-600">Display Name</label>
                  <input
                    class="form-control b-primary-v2"
                    placeholder="..."
                    v-model="form.display_name"
                    name="display_name"
                    @input="handleInput"
                    required
                    :disabled="customerFieldsDisabled"
                  />
                  <div class="text-danger" v-if="form.errors.display_name">{{ form.errors.display_name }}</div>
                </div>
                <hr />
                <div class="col-md-12">
                  <div class="mb-3">
                    <label class="form-label f-w-600">Address</label>
                    <vue-google-autocomplete
                      id="add_street_address_customer_detail"
                      name="add_street_address_customer_detail"
                      classname="form-control b-primary-v2"
                      placeholder="Home Address"
                      @input="onCustomerAddressChange"
                      required
                      v-on:placechanged="getAddressData"
                      :country="['us']"
                      :type="['address']"
                    >
                    </vue-google-autocomplete>
                    <div class="text-danger" v-if="form.errors.street_address">{{ form.errors.street_address }}</div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                      <label class="form-label f-w-600">City</label>
                      <input
                        class="form-control b-primary-v2"
                        type="text"
                        placeholder="City"
                        name="city"
                        v-model="form.city"
                        @input="handleInput"
                        required
                        :disabled="customerFieldsDisabled"
                      />
                      <div class="text-danger" v-if="form.errors.city">{{ form.errors.city }}</div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-6">
                    <div class="mb-3">
                      <label class="form-label f-w-600">Postal Code</label>
                      <input
                        class="form-control b-primary-v2"
                        type="number"
                        placeholder="ZIP Code"
                        name="zip_code"
                        v-model="form.zip_code"
                        @input="handleInput"
                        required
                        :disabled="customerFieldsDisabled"
                      />
                      <div class="text-danger" v-if="form.errors.zip_code">{{ form.errors.zip_code }}</div>
                    </div>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label f-w-600">State</label>
                  <input
                    class="form-control b-primary-v2"
                    type="text"
                    placeholder="State"
                    name="state"
                    v-model="form.state"
                    @input="handleInput"
                    required
                    :disabled="customerFieldsDisabled"
                  />
                  <div class="text-danger" v-if="form.errors.state">{{ form.errors.state }}</div>
                </div>
                <hr />
                <div class="mb-3">
                  <label class="form-label f-w-600">Primary Phone</label>
                  <input
                    class="form-control b-primary-v2"
                    placeholder="..."
                    v-model="form.phone"
                    name="phone"
                    @input="handleInput"
                    required
                    :disabled="customerFieldsDisabled"
                    v-mask="'(###) ###-####'"
                  />
                  <div class="text-danger" v-if="form.errors.phone">{{ form.errors.phone }}</div>
                </div>
                <div class="mb-3">
                  <label class="form-label f-w-600">Other Phone (Optional)</label>
                  <input
                    class="form-control b-primary-v2"
                    placeholder="..."
                    v-model="form.cell_phone"
                    name="cell_phone"
                    @input="handleInput"
                    :disabled="customerFieldsDisabled"
                    v-mask="'(###) ###-####'"
                  />
                  <div class="text-danger" v-if="form.errors.cell_phone">{{ form.errors.cell_phone }}</div>
                </div>
                <div class="mb-3">
                  <label class="form-label f-w-600">Email Address</label>
                  <input
                    class="form-control b-primary-v2"
                    placeholder="..."
                    v-model="form.email"
                    name="email"
                    @input="handleInput"
                    required
                    :disabled="customerFieldsDisabled"
                  />
                  <div class="text-danger" v-if="form.errors.email">{{ form.errors.email }}</div>
                </div>
                <div class="mb-3">
                  <label class="form-label f-w-600">Company</label>
                  <input
                    class="form-control b-primary-v2"
                    placeholder="..."
                    v-model="form.company"
                    name="company"
                    @input="handleInput"
                    required
                    :disabled="customerFieldsDisabled"
                  />
                  <div class="text-danger" v-if="form.errors.company">{{ form.errors.company }}</div>
                </div>

                <div class="mb-3">
                  <label class="form-label f-w-600">Stage</label>
                    <select class="form-control b-primary-v2" v-model="leadForm.stage" name="stage" required>
                      <option value="0" disabled selected>Select a deal stage...</option>
                      <option value="1">Cold Leads</option>
                      <option value="2">Warm Leads</option>
                      <option value="3">Estimated Requested</option>
                    </select>
                  <div class="text-danger" v-if="leadForm.errors.stage">{{ leadForm.errors.stage }}</div>
                </div>
              </form>
            </div>
          </div>

          <div class="card b-primary">
            <div class="card-header pb-0 d-flex justify-content-between">
              <h4 class="card-title mb-0">Security and Login</h4>
            </div>
            <div class="card-body">
              <div class="mb-3 row">
                <div class="col-sm-8 col-md-6">
                  <h5>Login Access</h5>
                </div>
                <div class="col-sm-4 col-md-6">
                  <span
                    style="
                      display: inline-block;
                      padding: 5px 10px;
                      background-color: #7c7878;
                      font-weight: bold;
                      border-radius: 10px;
                    "
                  >
                    INACTIVE <i class="fas fa-info-circle"></i>
                  </span>
                </div>
              </div>
              <div class="mb-3 row">
                <div class="col-sm-12 col-md-6">
                  <a class="btn btn-outline-primary">Send Invite</a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-8">
          <!-- <form class="card b-primary"> -->
          <div class="card b-primary-v2">
            <div class="card-header pb-0 d-flex justify-content-between">
              <div class="row">
                <div class="col-5">
                  <h4 class="card-title mb-0">Lead Opportunity Details</h4>
                </div>
                <div class="col-7">
                  <AutomationCard />
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="mb-3">
                    <label class="form-label f-w-600">Lead Title</label>
                    <input
                      class="form-control b-primary-v2"
                      type="text"
                      placeholder="Enter title..."
                      v-model="leadForm.opportunity_title"
                      name="opportunity_title"
                      @input="handleInput"
                      required
                      :disabled="processing"
                    />
                    <div class="text-danger" v-if="leadForm.errors.opportunity_title">
                      {{ leadForm.errors.opportunity_title }}
                    </div>
                  </div>
                </div>
                <div class="col-md-12 row">
                  <div class="mb-1 col-md-6">
                    <label class="form-label f-w-600">Description</label>
                    <textarea
                      class="form-control b-primary-v2"
                      rows="5"
                      placeholder="Enter lead description..."
                      v-model="leadForm.description"
                      name="description"
                      @input="handleInput"
                      :disabled="processing"
                    >
                    </textarea>
                    <div class="text-danger" v-if="leadForm.errors.description">{{ leadForm.errors.description }}</div>
                  </div>
                  <div class="col-md-6 d-flex flex-column gap-3 m-0 p-0">
                    <div>
                      <label class="form-label f-w-600">Appointment Set By</label
                      ><a @click="addDefaultUser" id="appointment_by" style="visibility: hidden">Test</a>
                      <Select2
                        v-model="appointedBy"
                        :className="'container-style-outlined-no-hover'"
                        :placeholder="'Select Crew Member'"
                        :id="'new-lead-appointed-by'"
                        :purpose="'multiple-select'"
                        :items="userData"
                        :selectedItems="appointedBy"
                        :isLoading="userLoading"
                        :disabled="processing"
                      />
                    </div>
                    <div class="row m-0 p-0">
                      <div class="col-md-12 mb-6 p-0">
                        <div class="d-flex justify-content-between align-items-center">
                          <label class="form-label f-w-600">Appointment Date</label>
                          <a
                            class="badge badge-dark"
                            style="height: 20px !important; cursor: pointer"
                            @click="handleCalendarClick"
                            id="check-schedule"
                            >Check Schedule</a
                          >
                        </div>
                        <FlatDateTimePicker @update-range="handleDateRange" />
                      </div>
                      <!-- <div class="col-md-6 row m-0 p-0">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <label class="form-label f-w-600">{{ leadForm.salesperson_ids.length > 1 ? 'Salespeople' : 'Salesperson'}}</label>
                                                        <div v-if="!sourceLoading">
                                                            <a class="badge badge-dark cursor-pointer" style="height: 20px !important;" @click="populateSalesperson" id="edit-lead-reset-salesperson">Reset</a>
                                                        </div>
                                                    </div>
                                                    <Select2 
                                                        v-model="leadForm.salesperson_ids"
                                                        :className="'container-style-outlined-no-hover'"
                                                        :placeholder="'Select Crew Member'" 
                                                        :id="'edit-lead-user-list'"
                                                        :purpose="'multiple-select'"
                                                        :items="salespersons"
                                                        :isLoading="userLoading"
                                                        :disabled="processing"
                                                    />
                                                </div> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card b-primary-v2">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="mb-3">
                    <div class="d-flex justify-content-between">
                      <label class="form-label f-w-600 mt-2">Address</label>
                      <a class="btn btn-primary-v2 btn-sm mb-2" @click="copyAddressFromCustomer"
                        ><i class="fa fa-copy"></i> Copy From Customer</a
                      >
                    </div>
                    <vue-google-autocomplete
                      id="street_address_new_lead"
                      name="street_address_new_lead"
                      classname="form-control b-primary-v2"
                      placeholder="Home Address"
                      @input="onLeadAddressChange"
                      required
                      v-on:placechanged="getAddressData"
                      :country="['us']"
                      :type="['address']"
                    >
                    </vue-google-autocomplete>
                    <div class="text-danger" v-if="leadForm.errors.street_address">
                      {{ leadForm.errors.street_address }}
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-4">
                  <div class="mb-3">
                    <label class="form-label f-w-600">City</label>
                    <input
                      class="form-control b-primary-v2"
                      type="text"
                      placeholder="City"
                      v-model="leadForm.city"
                      name="city"
                      @input="handleInput"
                      required
                      :disabled="processing"
                    />
                    <div class="text-danger" v-if="leadForm.errors.city">{{ leadForm.errors.city }}</div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-3">
                  <div class="mb-3">
                    <label class="form-label f-w-600">Postal Code</label>
                    <input
                      class="form-control b-primary-v2"
                      type="number"
                      placeholder="ZIP Code"
                      v-model="leadForm.zipcode"
                      name="zipcode"
                      @input="handleInput"
                      required
                      :disabled="processing"
                    />
                    <div class="text-danger" v-if="leadForm.errors.zipcode">{{ leadForm.errors.zipcode }}</div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="mb-3">
                    <label class="form-label f-w-600">State</label>
                    <input
                      class="form-control b-primary-v2"
                      type="text"
                      placeholder="State"
                      v-model="leadForm.state"
                      name="state"
                      @input="handleInput"
                      required
                      :disabled="processing"
                    />
                    <div class="text-danger" v-if="leadForm.errors.state">{{ leadForm.errors.state }}</div>
                  </div>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-6 col-md-4">
                  <div class="mb-3">
                    <label class="form-label f-w-600">Opportunity Phone</label>
                    <input
                      class="form-control b-primary-v2"
                      type="text"
                      placeholder="Enter Phone"
                      v-model="leadForm.opportunity_phone"
                      name="opportunity_phone"
                      @input="handleInput"
                      :disabled="processing"
                      v-mask="'(###) ###-####'"
                    />
                    <div class="text-danger" v-if="leadForm.errors.opportunity_phone">
                      {{ leadForm.errors.opportunity_phone }}
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-3">
                  <div class="mb-3">
                    <label class="form-label f-w-600">Cost of Lead</label>
                    <input
                      class="form-control b-primary-v2"
                      type="number"
                      placeholder="0"
                      v-model="leadForm.cost_of_lead"
                      name="cost_of_lead"
                      @input="handleInput"
                      :disabled="processing"
                    />
                    <div class="text-danger" v-if="leadForm.errors.cost_of_lead">
                      {{ leadForm.errors.cost_of_lead }}
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="mb-3">
                    <label class="form-label f-w-600">Status</label>
                    <select
                      class="form-control b-primary-v2"
                      v-model="leadForm.status"
                      name="status"
                      :disabled="processing"
                    >
                      <option value="open">Open</option>
                      <option value="pitch">Pitch - No Sale</option>
                      <option value="returned">Returned to Provider</option>
                      <option value="sold">Sold</option>
                    </select>
                    <div class="text-danger" v-if="leadForm.errors.status">{{ leadForm.errors.status }}</div>
                  </div>
                </div>
              </div>
              <hr />
              <div class="col-md-12 row m-0 p-0 pt-3">
                <div class="col-md-4">
                  <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label f-w-600">Tags</label>
                    <div v-if="!tagLoading">
                      <a
                        class="badge badge-dark cursor-pointer"
                        style="height: 20px !important"
                        @click="populateTag"
                        id="edit-lead-reset-tag"
                        >Reset</a
                      >
                      <a
                        class="badge badge-primary cursor-pointer"
                        data-bs-toggle="modal"
                        data-original-title="tagModal"
                        data-bs-target="#tagModal"
                        @click="handleTagClick('add')"
                        style="height: 20px !important"
                        >Add</a
                      >
                      <a
                        class="badge badge-secondary cursor-pointer"
                        data-bs-toggle="modal"
                        data-original-title="tagModal"
                        data-bs-target="#tagModal"
                        @click="handleTagClick('edit')"
                        style="height: 20px !important"
                        v-if="leadForm.tag_ids.length != 0"
                        >Edit</a
                      >
                    </div>
                  </div>
                  <Select2
                    v-model="leadForm.tag_ids"
                    :className="'container-style-outlined-no-hover'"
                    :placeholder="'Select Tags'"
                    :id="'edit-lead-tag-list'"
                    :purpose="'multiple-select'"
                    :items="tags"
                    :isLoading="tagLoading"
                    :disabled="processing"
                  />
                </div>
                <div class="col-md-4">
                  <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label f-w-600">Lead Source</label>
                    <div v-if="!sourceLoading">
                      <a
                        class="badge badge-dark cursor-pointer"
                        style="height: 20px !important"
                        @click="populateSource"
                        id="edit-lead-reset-source"
                        >Reset</a
                      >
                      <a
                        class="badge badge-primary cursor-pointer"
                        data-bs-toggle="modal"
                        data-original-title="sourceModal"
                        data-bs-target="#sourceModal"
                        @click="handleSourceClick('add')"
                        style="height: 20px !important"
                        >Add</a
                      >
                      <a
                        class="badge badge-secondary cursor-pointer"
                        data-bs-toggle="modal"
                        data-original-title="sourceModal"
                        data-bs-target="#sourceModal"
                        @click="handleSourceClick('edit')"
                        style="height: 20px !important"
                        v-if="leadForm.source_ids.length != 0"
                        >Edit</a
                      >
                    </div>
                  </div>
                  <Select2
                    v-model="leadForm.source_ids"
                    :className="'container-style-outlined-no-hover'"
                    :placeholder="'Select Sources'"
                    :id="'edit-lead-source-list'"
                    :purpose="'multiple-select'"
                    :items="sources"
                    :isLoading="sourceLoading"
                    :disabled="processing"
                  />
                </div>
                <div class="col-md-4">
                  <div class="d-flex justify-content-between align-items-center">
                    <label class="form-label f-w-600">Job Type</label>
                    <div v-if="!jobTypeLoading">
                      <a
                        class="badge badge-dark cursor-pointer"
                        style="height: 20px !important"
                        @click="populateJobType"
                        id="edit-lead-reset-jobtype"
                        >Reset</a
                      >
                      <a
                        class="badge badge-primary cursor-pointer"
                        data-bs-toggle="modal"
                        data-original-title="jobTypeModal"
                        data-bs-target="#jobTypeModal"
                        @click="handleJobTypeClick('add')"
                        style="height: 20px !important"
                        >Add</a
                      >
                      <a
                        class="badge badge-secondary cursor-pointer"
                        data-bs-toggle="modal"
                        data-original-title="jobTypeModal"
                        data-bs-target="#jobTypeModal"
                        @click="handleJobTypeClick('edit')"
                        style="height: 20px !important"
                        v-if="leadForm.jobtype_ids.length != 0"
                        >Edit</a
                      >
                    </div>
                  </div>
                  <Select2
                    v-model="leadForm.jobtype_ids"
                    :className="'container-style-outlined-no-hover'"
                    :placeholder="'Select Job Types'"
                    :id="'edit-lead-job-type-list'"
                    :purpose="'multiple-select'"
                    :items="jobtypes"
                    :isLoading="jobTypeLoading"
                    :disabled="processing"
                  />
                </div>
              </div>
            </div>
            <div class="card-footer text-end">
              <div class="form-footer text-end position-relative">
                <a
                  class="btn btn-primary-v2 btn-block send-options-toggle"
                  id="dropdownMenuButton"
                  @click="toggleSendOptions"
                  :disabled="processing"
                >
                  <i v-if="processing" class="fa fa-spin fa-spinner me-2"></i>
                  {{ processing ? "Loading..." : leadForm.lead_id ? "Update and ..." : "Save and ..." }}
                </a>
                <div
                  v-if="closeSendOption"
                  @click="toggleSendOptions"
                  class="sendOptions-popover d-flex flex-column"
                  style="background-color: white"
                >
                  <a
                    class="dropdown-item text-right m-0 p-1 bg-hover-primary"
                    @click="handleSubmit('new', $event)"
                    style="cursor: pointer !important"
                    >{{ leadForm.lead_id ? "Update" : "Save" }} and New</a
                  >
                  <a
                    class="dropdown-item text-right m-0 p-1 bg-hover-primary"
                    @click="handleSubmit('close', $event)"
                    style="cursor: pointer !important"
                    >{{ leadForm.lead_id ? "Update" : "Save" }} and Close</a
                  >
                  <a
                    class="dropdown-item text-right m-0 p-1 bg-hover-primary"
                    @click="handleSubmit('view', $event)"
                    style="cursor: pointer !important"
                    >{{ leadForm.lead_id ? "Update" : "Save" }} and View Lead</a
                  >
                  <a
                    class="dropdown-item text-right m-0 p-1 bg-hover-primary"
                    @click="handleSubmit('proposal', $event)"
                    style="cursor: pointer !important"
                    >{{ leadForm.lead_id ? "Update" : "Save" }} and Create Proposal</a
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <TagModal
    :type="tagAction"
    :selected="leadForm.tag_ids.length === 0 ? { id: 0, text: '' } : getSelectedTag(leadForm.tag_ids[0])"
    @click="handleTagChange"
  />
  <SourceModal
    :type="sourceAction"
    :selected="leadForm.source_ids.length === 0 ? { id: 0, text: '' } : getSelectedSource(leadForm.source_ids[0])"
    @click="handleSourceChange"
  />
  <JobTypeModal
    :type="jobTypeAction"
    :selected="leadForm.jobtype_ids.length === 0 ? { id: 0, text: '' } : getSelectedJobType(leadForm.jobtype_ids[0])"
    @click="handleJobTypeChange"
  />
</template>
<script>
import { useForm, usePage } from "@inertiajs/vue3";
import { useSideBar } from "../../../stores/sidebar";
import { Inertia } from "@inertiajs/inertia";
import { useCustomersModal } from "../../../stores/customers-modal";
import { useCalendarScheduleSidebar } from "../../../stores/calendar-schedule";
import axios from "axios";
import Swal from "sweetalert2";
import VueGoogleAutocomplete from "vue-google-autocomplete";
import Select2 from "./../../../components/Select2.vue";
import Breadcrumb from "../../../components/Breadcrumb.vue";
import FlatDateTimePicker from "./../../../components/FlatDateTimePicker.vue";
import AutomationCard from "../../../components/AutomationCard.vue";
import TagModal from "./TagModal.vue";
import SourceModal from "./SourceModal.vue";
import JobTypeModal from "./JobTypeModal.vue";

export default {
  props: ["errors", "appName", "company", "support", "csrf_token", "style", "flash", "pageTitle", "auth", "lead"],
  components: {
    Select2,
    Breadcrumb,
    FlatDateTimePicker,
    AutomationCard,
    VueGoogleAutocomplete,
    TagModal,
    SourceModal,
    JobTypeModal,
  },
  setup() {
    const page = usePage();
    const sidebarStore = useSideBar();
    const customersStore = useCustomersModal();
    const calendarStore = useCalendarScheduleSidebar();
    const form = useForm({
      cust_id: 0,
      first_name: "",
      last_name: "",
      display_name: "",
      phone: "",
      cell_phone: "",
      email: "",
      company: "",
      street_address: "",
      city: "",
      state: "",
      zip_code: "",
    });

    const leadForm = useForm({
      lead_id: 0,
      cust_id: 0,
      opportunity_title: "",
      street_address: "",
      city: "",
      state: "",
      zipcode: "",
      opportunity_phone: "",
      status: "open",
      description: "",
      cost_of_lead: 0,
      created_by: "",
      updated_by: "",
      tag_ids: [],
      source_ids: [],
      jobtype_ids: [],
      salesperson_ids: [],
      appointment: [],
      stage: 0,
    });

    const appointmentDetails = useForm({
      salespeople: [],
      apptDate: "",
      startDate: "",
      endDate: "",
      selectedSalesId: "",
    });

    return { page, form, leadForm, sidebarStore, customersStore, appointmentDetails, calendarStore };
  },
  data() {
    const customerFieldsDisabled = false;
    const processing = false;
    const sources = [];
    const sourceLoading = false;
    const sourceAction = "";
    const jobtypes = [];
    const jobTypeLoading = false;
    const jobTypeAction = "";
    const tags = [];
    const tagLoading = false;
    const tagAction = "";
    const salespersons = [];
    const userData = [];
    const userLoading = false;
    const appointedBy = [];
    const closeSendOption = false;
    const leadData = null;
    const customerData = null;
    const initialFormState = null;
    const CalendarEvents = [];

    return {
      customerFieldsDisabled,
      processing,
      sources,
      sourceLoading,
      jobtypes,
      jobTypeLoading,
      tags,
      tagLoading,
      salespersons,
      userData,
      userLoading,
      appointedBy,
      closeSendOption,
      leadData,
      customerData,
      initialFormState,
      tagAction,
      jobTypeAction,
      sourceAction,
      CalendarEvents,
    };
  },
  mounted() {
    this.sidebarStore.close();
    this.sidebarStore.setDisabled(true);

    if (this.page.props.lead) {
      this.leadData = this.page.props.lead;
      this.customerData = this.page.props.lead.lead_customer;
      this.initialFormState = { ...this.form };

      this.populateFormWithCustomerData();
      this.populateLeadFormWithLeadData();
    } else {
    }

    this.getAllTag();
    this.getAllSource();
    this.getAllJobType();
    this.fetchSalesPersons();
    this.getCalendarEvents();

    document.addEventListener("click", this.handleDocumentClick);
  },
  methods: {
    handleTagClick(type) {
      this.tagAction = type;
    },
    handleTagChange(value) {
      const type = value.type;
      const tag = value.value;

      if (type === "add") {
        this.tags.push({
          id: tag.id,
          text: tag.text,
        });
      } else if (type === "edit") {
        this.tags = this.tags.map((item) => {
          if (item.id === tag.id) {
            return { ...item, text: tag.text };
          }
          return item;
        });
      } else if (type === "delete") {
        this.tags = this.tags.filter((item) => item.id !== tag.id);
      }
    },
    handleSourceClick(type) {
      this.sourceAction = type;
    },
    handleSourceChange(value) {
      const type = value.type;
      const source = value.value;

      if (type === "add") {
        this.sources.push({
          id: source.id,
          text: source.text,
        });
      } else if (type === "edit") {
        this.sources = this.sources.map((item) => {
          if (item.id === source.id) {
            return { ...item, text: source.text };
          }
          return item;
        });
      } else if (type === "delete") {
        this.sources = this.sources.filter((item) => item.id !== source.id);
      }
    },
    handleJobTypeClick(type) {
      this.jobTypeAction = type;
    },
    handleJobTypeChange(value) {
      const type = value.type;
      const jobType = value.value;

      if (type === "add") {
        this.jobtypes.push({
          id: jobType.id,
          text: jobType.text,
        });
      } else if (type === "edit") {
        this.jobtypes = this.jobtypes.map((item) => {
          if (item.id === jobType.id) {
            return { ...item, text: jobType.text };
          }
          return item;
        });
      } else if (type === "delete") {
        this.jobtypes = this.jobtypes.filter((item) => item.id !== jobType.id);
      }
    },
    getSelectedTag(id) {
      return this.tags.find((item) => item.id == id);
    },
    getSelectedSource(id) {
      return this.sources.find((item) => item.id == id);
    },
    getSelectedJobType(id) {
      return this.jobtypes.find((item) => item.id == id);
    },
    addDefaultUser() {
      this.appointedBy.push(this.props.user_id);
    },
    onLeadAddressChange(value) {
      this.leadForm.street_address = value.target.value;
    },
    onCustomerAddressChange(value) {
      this.form.street_address = value.target.value;
    },
    handleSelectCustomer() {
      this.customersStore.setType("select");
      this.customersStore.toggleModal();
    },
    handleDocumentClick(event) {
      if (!event.target.closest(".send-options-toggle")) {
        this.closeSendOption = false;
      }
    },
    handleDeleteLead() {
      Swal.fire({
        icon: "warning",
        title: "Delete this lead?",
        text: "Are you sure you want to delete this lead?",
        showCancelButton: true,
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        reverseButtons: true,
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteLead();
        }
      });
    },
    toggleSendOptions() {
      this.closeSendOption = !this.closeSendOption;
    },
    handleEditCustomer() {
      this.customerFieldsDisabled = false;
    },
    hasFormChanged() {
      return Object.keys(this.form).some((key) => this.form[key] !== this.initialFormState[key]);
    },
    populateLeadFormWithLeadData() {
      if (this.leadData) {
        this.leadForm.lead_id = this.leadData.lead_id || 0;
        this.leadForm.cust_id = this.leadData.cust_id || 0;
        this.leadForm.opportunity_title = this.leadData.opportunity_title || "";
        this.leadForm.street_address = this.leadData.street_address || "";
        this.leadForm.city = this.leadData.city || "";
        this.leadForm.state = this.leadData.state || "";
        this.leadForm.zipcode = this.leadData.zipcode || "";
        this.leadForm.opportunity_phone = this.leadData.opportunity_phone || "";
        this.leadForm.status = this.leadData.status || "open";
        this.leadForm.description = this.leadData.description || "";
        this.leadForm.cost_of_lead = this.leadData.cost_of_lead || 0;
        this.leadForm.created_by = this.leadData.created_by || "";
        this.leadForm.updated_by = this.leadData.updated_by || "";

        $("#street_address_new_lead").val(this.leadForm.street_address);
      }
    },
    populateFormWithCustomerData() {
      if (this.customerData) {
        this.populateFormWithCustomer(this.customerData);
      }
    },
    populateFormWithCustomer(selectedCustomer) {
      this.leadForm.cust_id = selectedCustomer.cust_id;
      this.form.cust_id = selectedCustomer.cust_id;
      this.form.first_name = selectedCustomer.first_name;
      this.form.last_name = selectedCustomer.last_name;
      this.form.display_name = selectedCustomer.display_name;
      this.form.phone = selectedCustomer.phone;
      this.form.cell_phone = selectedCustomer.cell_phone;
      this.form.email = selectedCustomer.email;
      this.form.company = selectedCustomer.company;
      this.form.street_address = selectedCustomer.street_address;
      this.form.city = selectedCustomer.city;
      this.form.state = selectedCustomer.state;
      this.form.zip_code = selectedCustomer.zip_code;
      this.customerFieldsDisabled = true;

      $("#add_street_address_customer_detail").val(this.form.street_address);
      this.initialFormState = { ...this.form };
    },
    copyAddressFromCustomer() {
      this.leadForm.street_address = this.form.street_address;
      this.leadForm.city = this.form.city;
      this.leadForm.zipcode = this.form.zip_code;
      this.leadForm.state = this.form.state;
      this.leadForm.opportunity_phone = this.form.cell_phone;

      $("#street_address_new_lead").val(this.leadForm.street_address);
    },
    handleInput(e) {
      this.leadForm.clearErrors(e.target.name);
      this.form.clearErrors(e.target.name);
    },
    async handleSubmit(type, event) {
      this.processing = true;
      event.preventDefault();

      if (this.leadForm.cust_id === 0) {
        try {
          const customerResponse = await this.saveCustomer();
          if (customerResponse.data.status !== "success") {
            this.initialFormState = { ...this.form };
            this.processing = false;
            return;
          }
        } catch (error) {
          this.processing = false;
          return;
        }
      } else if (this.hasFormChanged()) {
        try {
          await this.updateCustomer();
        } catch (error) {
          this.processing = false;
          return;
        }
      }

      try {
        if (this.leadForm.opportunity_phone) {
          this.leadForm.opportunity_phone = this.leadForm.opportunity_phone.replace(/\D/g, "");
        }

        this.leadForm.appointment = this.appointmentDetails;

        const url = this.leadForm.lead_id ? `/api/updateLead/${this.leadForm.lead_id}` : "/api/saveLead";
        const response = await axios.post(url, this.leadForm, {
          headers: {
            Authorization: "Bearer " + this.page.props.csrf_token,
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
          },
        });

        if (response.data.status === "success") {
          const lead_id = response.data.data.id;

          this.customerFieldsDisabled = false;
          this.form.reset();
          this.leadForm.reset();

          this.leadForm.salesperson_ids = [];
          this.leadForm.tag_ids = [];
          this.leadForm.source_ids = [];
          this.leadForm.jobtype_ids = [];

          $("#add_street_address_customer_detail").val("");
          $("#street_address_new_lead").val("");

          if (type === "view") {
            this.processing = true;
            Inertia.get(`/sales/lead-management/view-lead/${lead_id}`);
          } else if (type === "proposal") {
            this.processing = true;
            Inertia.get(`/sales/lead-management/proposal/0/${lead_id}`);
          } else if (type === "close") {
            this.processing = true;
            Inertia.get("/sales/lead-management");
          } else if (type === "new") {
            this.processing = true;
            Inertia.get(`/sales/lead-management/new`);
          }

          Swal.fire({
            icon: "success",
            title: "Success!",
            text: "Data has been sent successfully!",
          });
        } else if (response.data.status === "error" && response.data.errors) {
          for (const [field, error] of Object.entries(response.data.errors)) {
            this.leadForm.errors[field] = error[0];
          }
        }

        this.processing = false;
      } catch (error) {
        this.processing = false;
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "There was a problem when saving the data!",
        });
      }
    },
    async deleteLead() {
      this.processing = true;
      this.customerFieldsDisabled = true;
      try {
        const response = await axios.post(`/api/deleteLead/${this.leadForm.lead_id}`, this.form, {
          headers: {
            Authorization: "Bearer " + this.page.props.csrf_token,
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
          },
        });

        if (response.data.status !== "success") {
          throw new Error("Failed to update customer");
        } else {
          this.customerFieldsDisabled = false;
          this.form.reset();
          this.leadForm.reset();
          Swal.fire({
            icon: "success",
            title: "Success!",
            text: "Data has been DELETED successfully!",
          });
          // Go back to the previous page
          window.history.back();
        }
        this.processing = false;
        return response;
      } catch (error) {
        this.processing = false;
        throw error;
      }
    },
    async saveCustomer() {
      this.customerFieldsDisabled = true;
      try {
        if (this.form.phone) {
          this.form.phone = this.form.phone.replace(/\D/g, "");
        }
        if (this.form.cell_phone) {
          this.form.cell_phone = this.form.cell_phone.replace(/\D/g, "");
        }
        const response = await axios.post("/api/saveCustomer", this.form, {
          headers: {
            Authorization: "Bearer " + this.page.props.csrf_token,
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
          },
        });

        if (response.data.status === "success") {
          this.leadForm.cust_id = response.data.data.id;
          this.form.cust_id = response.data.data.id;
          this.customerFieldsDisabled = true;
        } else if (response.data.status === "error" && response.data.errors) {
          for (const [field, error] of Object.entries(response.data.errors)) {
            form.errors[field] = error[0];
          }
          this.customerFieldsDisabled = false;
        }
        return response; // Return the axios response
      } catch (error) {
        this.customerFieldsDisabled = false;
        throw error; // Throw the error to be caught in the calling function
      }
    },
    async updateCustomer() {
      this.customerFieldsDisabled = true;
      try {
        if (this.form.phone) {
          this.form.phone = this.form.phone.replace(/\D/g, "");
        }
        if (this.form.cell_phone) {
          this.form.cell_phone = this.form.cell_phone.replace(/\D/g, "");
        }
        const response = await axios.post(`/api/updateCustomer/${this.form.cust_id}`, this.form, {
          headers: {
            Authorization: "Bearer " + this.page.props.csrf_token,
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
          },
        });

        if (response.data.status !== "success") {
          throw new Error("Failed to update customer");
        }
        return response;
      } catch (error) {
        throw error;
      }
    },
    async fetchSalesPersons() {
      try {
        this.userLoading = true;
        const response = await axios.get("/api/userContacts", {
          headers: {
            Authorization: "Bearer " + this.page.props.csrf_token,
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
          },
        });
        const data = response.data;
        this.salespersons = Object.values(data.data).map((userDetails) => {
          if (userDetails.user_id) {
            return {
              text: userDetails.display_name,
              id: userDetails.user_id ? userDetails.user_id : userDetails.cust_id,
              email: userDetails.email,
              phone: userDetails.phone,
            };
          } else {
            return false;
          }
        });

        // this.$nextTick(() => {
        //   document.querySelector("#edit-lead-reset-salesperson").click();
        // });

        this.userLoading = false;
      } catch (error) {
        console.error("Error fetching customers: ", error);
      }
    },
    populateSalesperson() {
      if (this.page.props.lead && this.page.props.lead.sales_people) {
        const usersData = Object.values(this.page.props.lead.sales_people).map((user) => user.user_id);
        this.leadForm.salesperson_ids = usersData;
      }
    },
    populateTag() {
      if (this.page.props.lead && this.page.props.lead.tags) {
        const tagsData = Object.values(this.page.props.lead.tags).map((tag) => tag.tags_id);
        this.leadForm.tag_ids = tagsData;
      }
    },
    populateSource() {
      if (this.page.props.lead && this.page.props.lead.sources) {
        const sourcesData = Object.values(this.page.props.lead.sources).map((source) => source.source_id);
        this.leadForm.source_ids = sourcesData;
      }
    },
    populateJobType() {
      if (this.page.props.lead && this.page.props.lead.job_types) {
        const jobTypesData = Object.values(this.page.props.lead.job_types).map((job_type) => job_type.job_type_id);
        this.leadForm.jobtype_ids = jobTypesData;
      }
    },
    async getAllTag() {
      try {
        this.tagLoading = true;
        const response = await axios.get("/api/tags", this.form, {
          headers: {
            Authorization: "Bearer " + this.page.props.csrf_token,
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
          },
        });

        if (response.status === 200) {
          const data = response.data;
          this.tags = Object.values(data.data).map((tag) => {
            return {
              id: tag.tags_id,
              text: tag.tags_name,
            };
          });

          this.tagLoading = false;

          this.$nextTick(() => {
            document.querySelector("#edit-lead-reset-tag").click();
          });
        } else {
          this.tagLoading = false;
          console.log(response);
        }
      } catch (error) {
        this.tagLoading = false;
        console.log(error);
      }
    },
    async getAllSource() {
      try {
        this.sourceLoading = true;
        const response = await axios.get("/api/sources", this.form, {
          headers: {
            Authorization: "Bearer " + this.page.props.csrf_token,
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
          },
        });

        if (response.status === 200) {
          const data = response.data;
          this.sources = Object.values(data.data).map((source) => {
            return {
              id: source.source_id,
              text: source.source_name,
            };
          });

          this.sourceLoading = false;

          this.$nextTick(() => {
            document.querySelector("#edit-lead-reset-source").click();
          });
        } else {
          this.sourceLoading = false;
          console.log(response);
        }
      } catch (error) {
        this.sourceLoading = false;
        console.log(error);
      }
    },
    async getAllJobType() {
      try {
        this.jobTypeLoading = true;
        const response = await axios.get("/api/jobTypes", this.form, {
          headers: {
            Authorization: "Bearer " + this.page.props.csrf_token,
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
          },
        });

        if (response.status === 200) {
          const data = response.data;
          this.jobtypes = Object.values(data.data).map((jobtype) => {
            return {
              id: jobtype.job_type_id,
              text: jobtype.job_type_name,
            };
          });

          this.jobTypeLoading = false;

          this.$nextTick(() => {
            document.querySelector("#edit-lead-reset-jobtype").click();
          });
        } else {
          this.jobTypeLoading = false;
          console.log(response);
        }
      } catch (error) {
        this.jobTypeLoading = false;
        console.log(error);
      }
    },
    async getAddressData(addressData, placeResultData, id) {
      const placeAddress = placeResultData.address_components;

      let streetAddress = "";

      for (const component of placeAddress) {
        const componentType = component.types[0];
        switch (componentType) {
          case "street_number":
            streetAddress = component.long_name;
            break;
          case "route":
            streetAddress += " " + component.long_name;
            break;
          case "postal_code":
            if (id === "street_address_new_lead") this.leadForm.zipcode = component.long_name;
            else this.form.zip_code = component.long_name;
            break;
          case "administrative_area_level_1":
            if (id === "street_address_new_lead") this.leadForm.state = component.long_name;
            else this.form.state = component.long_name;
            break;
          case "administrative_area_level_2":
            if (id === "street_address_new_lead") this.leadForm.state = component.long_name;
            else this.form.state = component.long_name;
            break;
          case "neighborhood":
            if (id === "street_address_new_lead") this.leadForm.city = component.long_name;
            else this.form.city = component.long_name;
            break;
        }
      }

      if (streetAddress) {
        if (id === "street_address_new_lead") {
          $("#street_address_new_lead").val(streetAddress);
          this.leadForm.street_address = streetAddress;
        } else {
          $("#add_street_address_customer_detail").val(streetAddress);
          this.form.street_address = streetAddress;
        }
      }
    },
    handleDateRange(range) {
      this.appointmentDetails.apptDate = range.apptDate.toLocaleString();
      this.appointmentDetails.startDate = range.startDate.toLocaleString();
      this.appointmentDetails.endDate = range.endDate.toLocaleString();

      this.handleCalendarClick();
    },
    handleCalendarClick() {
      this.calendarStore.setApptDate(this.appointmentDetails.apptDate);
      this.calendarStore.setSalesPerson(this.salespersons);
      this.calendarStore.open();
    },
    getCalendarEvents(){
      axios.get('/api/calendar/getData').then(response => {
        this.CalendarEvents  = response.data.data;
      });
    }
  },
  computed: {
    first_name() {
      return this.form.first_name;
    },
    last_name() {
      return this.form.last_name;
    },
    display_name() {
      return this.form.display_name;
    },
    street_address() {
      return this.form.street_address;
    },
    selectedCustomer() {
      return this.customersStore.selected;
    },
    apptDate() {
      return this.calendarStore.apptDate;
    },
    startDate() {
      return this.calendarStore.startDate;
    },
    endDate() {
      return this.calendarStore.endDate;
    },
    selectedSalesPeople() {
      return this.calendarStore.selectedSalesPerson;
    },
    selectedSalesId() {
      return this.calendarStore.selectedSalesId;
    },
  },
  watch: {
    first_name: {
      handler(newFirstName) {
        this.form.display_name = `${newFirstName} ${this.form.last_name}`;
      },
    },
    last_name: {
      handler(newLastName) {
        this.form.display_name = `${this.form.first_name} ${newLastName}`;
      },
    },
    display_name: {
      handler(newDisplayname) {
        this.leadForm.opportunity_title = `${newDisplayname} - ${this.form.street_address}`;
      },
    },
    street_address: {
      handler(newAddress) {
        this.leadForm.opportunity_title = `${this.form.display_name} - ${newAddress}`;
      },
    },
    customerFieldsDisabled: {
      handler(newValue) {
        $("#add_street_address_customer_detail").prop("disabled", newValue);
      },
    },
    processing: {
      handler(newValue) {
        $("#street_address_new_lead").prop("disabled", newValue);
      },
    },
    selectedCustomer: {
      handler(selectedCustomer) {
        if (selectedCustomer) {
          this.populateFormWithCustomer(selectedCustomer);
        }
      },
    },
    apptDate: {
      handler(calApptDate) {
        if (calApptDate) {
          this.appointmentDetails.apptDate = calApptDate;
        }
      },
    },
    startDate: {
      handler(calStartDate) {
        if (calStartDate) {
          this.appointmentDetails.startDate = calStartDate;
        }
      },
    },
    endDate: {
      handler(calEndDate) {
        if (calEndDate) {
          this.appointmentDetails.endDate = calEndDate;
        }
      },
    },
    selectedSalesPeople: {
      handler(salespersons) {
        if (salespersons) {
          this.appointmentDetails.salespersons = salespersons;
        }
      },
    },
    selectedSalesId: {
      handler(SalesId) {
        if (SalesId) {
          this.appointmentDetails.selectedSalesId = SalesId;
        }
      },
    },
  },
};
</script>
