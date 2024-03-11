<template>
    <div class="page-header p-3">
        <div class="row">
            <div class="col-sm-6">
                <Breadcrumb 
                    :page_title="proposalForm.title ? proposalForm.title : 'New Change Order'"
                    :last_page_title="'Change Order'"
                />
            </div>
            <div class="col-sm-6">

            </div>
        </div>
    </div>
    <div class="container-fluid" style="background-color: #f5f7fb;">
        <input type="hidden" :value="page.props.csrf_token" name="_token">
            <div class="edit-profile">
              <div class="row">
                <div class="col-xl-4">
                    <div class="d-flex flex-column">
                        <div class="card b-primary">
                            <div class="card-header pb-0 d-flex justify-content-between">
                                <h4 class="card-title mb-0">Lead Details</h4>
				                <a class="btn btn-outline-danger" style="height: 35px !important;" v-if="leadForm.lead_id != 0" @click="handleChangeLead">CHANGE</a>
                                <a class="btn btn-outline-primary swing"  data-bs-toggle="modal" data-original-title="selectLeads" data-bs-target="#selectLeads" style="height: 35px !important;" v-else @click="handleSelectLead">SELECT</a>
                            </div>
                            <div class="card-body" v-if="leadForm.lead_id == 0">
                                <label class="col-sm-12 col-form-label f-w-700 pr-0 pl-2 text-center" for="inputEmail3" style="color: gray;">SELECT LEAD TO GET STARTED</label>
                            </div>
                            <div class="card-body pb-1" v-else>
                                <form class="theme-form">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label f-w-700 pr-0 pl-2" for="inputEmail3">Lead Title:</label>
                                        <div class="col-sm-9">
                                            <label class="col-form-label f-w-500" for="inputEmail3">{{ leadForm.opportunity_title }}</label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label f-w-700 pr-0 pl-2" for="inputEmail3">Address:</label>
                                        <div class="col-sm-9">
                                            <label class="col-form-label f-w-500" for="inputEmail3">{{ leadForm.street_address + ' ' + leadForm.city + ' ' + leadForm.state + ' ' + leadForm.zipcode }}</label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label f-w-700 pr-0 pl-2" for="inputEmail3">Phone:</label>
                                        <div class="col-sm-9">
                                            <label class="col-form-label f-w-500" for="inputEmail3">{{ formatPhoneNumber(leadForm.opportunity_phone) }}</label>
                                        </div>
                                    </div>
                                    <div :class="[ showMore ? 'd-none' : '', 'mb-3 row']">
                                        <label class="col-sm-3 col-form-label f-w-700 pr-0 pl-2" for="inputEmail3">Salespeople:</label>
                                        <div class="col-sm-9 d-flex align-items-center justify-content-start wrap-content" v-html="salesPeople">
                                        </div>
                                    </div>
                                    <div :class="[ showMore ? 'd-none' : '', 'mb-3 row']">
                                        <label class="col-sm-3 col-form-label f-w-700 pr-0 pl-2" for="inputEmail3">Tags:</label>
                                        <div class="col-sm-9 d-flex align-items-center justify-content-start wrap-content" v-html="tags">
                                        </div>
                                    </div>
                                    <div :class="[ showMore ? 'd-none' : '', 'mb-3 row']">
                                        <label class="col-sm-3 col-form-label f-w-700 pr-0 pl-2" for="inputEmail3">Sources:</label>
                                        <div class="col-sm-9 d-flex align-items-center justify-content-start wrap-content" v-html="sources">
                                        </div>
                                    </div>
                                    <div :class="[ showMore ? 'd-none' : '', 'mb-3 row']">
                                        <label class="col-sm-3 col-form-label f-w-700 pr-0 pl-2" for="inputEmail3">Job Type:</label>
                                        <div class="col-sm-9 d-flex align-items-center justify-content-start wrap-content" v-html="jobTypes">
                                        </div>
                                    </div>
                                    <div :class="[ showMore ? 'd-none' : '', 'mb-3 row']">
                                        <label class="col-sm-3 col-form-label f-w-700 pr-0 pl-2" for="inputEmail3">Cost of Lead:</label>
                                        <div class="col-sm-9">
                                            <label class="col-form-label f-w-500" for="inputEmail3">{{ leadForm.cost_of_lead != 0 ? leadForm.cost_of_lead : 'N/A' }}</label>
                                        </div>
                                    </div>
                                    <div :class="[ showMore ? 'd-none' : '', 'mb-3 row']">
                                        <label class="col-sm-3 col-form-label f-w-700 pr-0 pl-2" for="inputEmail3">Description:</label>
                                        <div class="col-sm-9">
                                            <label class="col-form-label f-w-500" for="inputEmail3">{{ leadForm.description }}</label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-12 col-form-label text-center cursor-pointer" for="inputEmail3"  @click="toggleShow">
                                            {{ showMore ? 'Show more' : 'Show less'}}
                                            <i :class="showMore ? 'fa fa-sort-down' : 'fa fa-sort-up'"></i>
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card b-primary"  v-if="leadForm.lead_id != 0">
                            <div class="card-header pb-0 d-flex justify-content-between">
                                <h4 class="card-title mb-0">Customer Details</h4>
                            </div>
                            <div class="card-body">
                                <form class="theme-form">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label f-w-700 pr-0 pl-2" for="inputEmail3">Name:</label>
                                        <div class="col-sm-9">
                                            <label class="col-form-label f-w-500" for="inputEmail3">{{ form.display_name }}</label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label f-w-700 pr-0 pl-2" for="inputEmail3">Address:</label>
                                        <div class="col-sm-9">
                                            <label class="col-form-label f-w-500" for="inputEmail3">{{ form.street_address + ' ' + form.city + ' ' + form.state + ' ' + form.zip_code }}</label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label f-w-700 pr-0 pl-2" for="inputEmail3">Phone:</label>
                                        <div class="col-sm-9">
                                            <label class="col-form-label f-w-500" for="inputEmail3">{{ formatPhoneNumber(form.phone) }}</label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label f-w-700 pr-0 pl-2" for="inputEmail3">Other:</label>
                                        <div class="col-sm-9">
                                            <label class="col-form-label f-w-500" for="inputEmail3">{{ formatPhoneNumber(form.cell_phone) }}</label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label f-w-700 pr-0 pl-2" for="inputEmail3">Email:</label>
                                        <div class="col-sm-9">
                                            <label class="col-form-label f-w-500" for="inputEmail3">{{ form.email }}</label>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label f-w-700 pr-0 pl-2" for="inputEmail3">Company:</label>
                                        <div class="col-sm-9">
                                            <label class="col-form-label f-w-500" for="inputEmail3">{{ form.company }}</label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8 order-first">
                    <div class="card b-primary">
                        <div class="card-header pb-0">
                        <h4 class="card-title mb-0">Change Order Details <span :class="[proposalStatusColor, 'badge']" style="float: right;" v-if="leadForm.lead_id != 0">{{ proposalStatus }}</span></h4>
                        <small v-if="proposalForm.title != ''">For {{ proposalForm.title }}</small>
                        <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
                        </div>
                        <div class="card-body" v-if="leadForm.lead_id == 0">
                            <label class="col-sm-12 col-form-label f-w-700 pr-0 pl-2 text-center" for="inputEmail3" style="color: gray;">SELECT LEAD TO GET STARTED</label>
                        </div>
                        <div class="card-body" v-else>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="mb-3">
                                        <label class="form-label f-w-600">Proposal Title</label>
                                        <input class="form-control border-success" type="text" placeholder="Enter title..." name="proposal_title" @input="handleInput" v-model="proposalForm.title" :disabled="processing">
                                        <div class="text-danger" v-if="proposalForm.errors.title">{{ proposalForm.errors.title }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label f-w-600">Approval Deadline</label>
                                        <input class="form-control digits border-success" type="date" v-model="proposalForm.approval_deadline" :disabled="processing">
                                        <div class="text-danger" v-if="proposalForm.errors.approval_deadline">{{ proposalForm.errors.approval_deadline }}</div>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <ul class="nav nav-pills mt-5" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-worksheet-tab" data-bs-toggle="pill" href="#pills-worksheet" role="tab" aria-controls="pills-worksheet" aria-selected="true">
                                        <i class="icofont icofont-spreadsheet"></i>Worksheet
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-payment-tab" data-bs-toggle="pill" href="#pills-payment" role="tab" aria-controls="pills-payment" aria-selected="false">
                                        <i class="icofont icofont-stripe-alt"></i>Payment Schedule
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-extra-details-tab" data-bs-toggle="pill" href="#pills-extra-details" role="tab" aria-selected="true">
                                        <i class="icofont icofont-info-square"></i>Legal
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-preview-tab" data-bs-toggle="pill" href="#pills-preview" role="tab" aria-controls="pills-preview" aria-selected="false" @click="generatePDF">
                                        <i class="icofont icofont-file-document"></i>Preview
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-icontabContent">
                                <div class="tab-pane fade active show" id="pills-worksheet" role="tabpanel" aria-labelledby="pills-worksheet-tab">
                                    <hr/>
                                    <div class="container" v-if="fetchingData">
                                        <div class="col-md-12 d-flex flex-column align-items-center">
                                            <div style="width: 200px; height: 130px;">
                                                <div class="loader-box">
                                                    <div class="loader-17"></div>
                                                </div>
                                            </div>
                                            <h3 class="text-dark text-center">Loading...</h3>
                                        </div>
                                    </div>
                                    <div class="container" v-else-if="proposalForm.worksheet.length == 0">
                                        <div class="col-md-12 d-flex align-items-center justify-content-between">
                                            <div class="d-flex flex-column align-items-center">
                                                <div style="width: 200px; height: 180px;">
                                                    <img src="../../../assets/sales/empty-item-list.png" alt="">
                                                </div>
                                                <h3 class="text-dark text-center pt-2">CREATE ITEM</h3>
                                                <p class="sub-content text-center">Add your very first item in this proposal.</p>
                                                <a class="btn btn-outline-primary" style="width: auto;" @click="handleAddItem">ADD ITEM</a>
                                            </div>
                                            <div class="d-flex flex-column align-items-center">
                                                <div style="width: 200px; height: 180px;">
                                                    <img src="../../../assets/sales/empty-item-list.png" alt="">
                                                </div>
                                                <h3 class="text-dark text-center pt-2">ADD FROM CATALOG</h3>
                                                <p class="sub-content text-center">Import items from catalog to this proposal.</p>
                                                <a class="btn btn-outline-primary" style="width: auto;" @click="handleCatalogClicked">Import from Catalog</a>
                                            </div>
                                            <div class="d-flex flex-column align-items-center">
                                                <div style="width: 200px; height: 180px;">
                                                    <img src="../../../assets/sales/empty-item-list.png" alt="">
                                                </div>
                                                <h3 class="text-dark text-center pt-2">SMART ESTIMATE</h3>
                                                <p class="sub-content text-center">Import items from smart estimate</p>
                                                <a class="btn btn-outline-primary" style="width: auto;" @click="handleEstimateClicked">Import from Estimate</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div  v-else>
                                        <div class="d-flex pb-3 pt-1">
                                            <div>
                                                <a class="f-w-700">Total Owner Price</a>
                                                <h5 class="f-w-300">{{ sumOwnerPrice }}</h5>
                                            </div>
                                            <div class="mx-4 mt-4"><h5>-</h5></div>
                                            <div>
                                                <a class="f-w-700">Total Builder Cost</a>
                                                <h5 class="f-w-300">{{ sumBuilderCost }}</h5>
                                            </div>
                                            <div class="mx-4 mt-4"><h5>=</h5></div>
                                            <div>
                                                <a class="f-w-700">Estimated Profit</a>
                                                <h5 class="f-w-300">{{ estimatedProfit }}</h5>
                                            </div>
                                            <div class="mx-4 mt-4 position-relative">
                                                <a class="cursor-pointer break-pop-over" @click="toggleBreakDownPopover">Breakdown <i class="icofont icofont-info-circle"></i></a>
                                                    <!-- Popover Content -->
                                                    <div 
                                                        v-if="showPopoverBreakDown"
                                                        @click="toggleBreakDownPopover"
                                                        class="breakdown-popover d-flex flex-column"
                                                        >
                                                        <div class="d-flex">
                                                            <a style="width: 160px;">Total Builder Cost:</a>
                                                            <b class="flex-grow-1 text-right">{{ sumBuilderCost }}</b>
                                                        </div>
                                                        <div class="d-flex">
                                                            <a style="width: 160px;">Total Markup:</a>
                                                            <b class="flex-grow-1 text-right">{{ totalMarkup }}</b>
                                                        </div>
                                                        <div class="d-flex">
                                                            <a style="width: 160px;"><b>Total Owner Price:</b></a>
                                                            <b class="flex-grow-1 text-right">{{ sumOwnerPrice }}</b>
                                                        </div>
                                                        <div class="d-flex">
                                                            <a style="width: 160px;">Total Margin %:</a>
                                                            <b class="flex-grow-1 text-right">{{ totalMargin }}</b>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="mb-3 d-flex justify-content-between">
                                            <button 
                                                class="btn btn-secondary mr-2" 
                                                type="button"
                                                style="color: white"
                                                @click="undoChanges"
                                                :class="JSON.stringify(initialWorksheet) !== JSON.stringify(proposalForm.worksheet) ? '' : 'd-none'">Undo Changes</button>
                                            <div></div>
                                            <div>
                                                <div class="btn position-relative p-0 mr-2">
		                                            <div class="btn btn-outline-customize import-pop-over" @click="toggleImportPopover"  style="width: auto;"><i class="icon-import mr-2"></i>Import</div>
                                                    <div 
                                                        v-if="showImportOptions"
                                                        @click="toggleImportPopover"
                                                        class="import-popover d-flex cursor-default"
                                                        >
                                                        <div class="d-flex flex-column justify-item-center align-items-center text-dark import-hover-effect p-2 cursor-pointer"
                                                            @click="handleCatalogClicked">
                                                            <i class="icon-book f-40"></i>
                                                            <span class="mt-2 f-w-600">From Catalog</span>
                                                        </div>
                                                        <div class="bg-primary mx-3" style="width: 1px; height: 120;"></div>
                                                        <div class="d-flex flex-column justify-item-center align-items-center text-dark import-hover-effect p-2 cursor-pointer"
                                                            @click="handleEstimateClicked">
                                                            <i class="icon-stats-up f-40"></i>
                                                            <span class="mt-2 f-w-600">From Estimates</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button 
                                                    v-if="checkedItems.length != 0" 
                                                    class="btn btn-danger mr-2" 
                                                    type="button" 
                                                    style="color: white"
                                                    @click="deleteCheckedItems">Delete</button>
                                                <button 
                                                    class="btn btn-primary" 
                                                    type="button" 
                                                    data-bs-toggle="modal" 
                                                    data-original-title="addItem" 
                                                    data-bs-target="#addItem">{{ checkedItems.length == 1 ? 'Update Item' : 'Add Item' }}</button>
                                            </div>
                                        </div>
                                        <div class="overflow-handler flex-grow-1 d-flex flex-column">
                                            <div class="table-responsive flex-grow-1">
                                                <table class="table" id="proposal-list">
                                                    <thead>
                                                        <tr>
                                                            <template v-for="(col, index) in worksheetColumns" :key="col.field">
                                                                <th 
                                                                    class='f-w-500' 
                                                                    :style="{ width: col.width + 'px' }"
                                                                    :class="{
                                                                        'left-sticky-title': index === 0,
                                                                        'sticky': index === worksheetColumns.length - 1, 
                                                                        'sticky-second-last': index === worksheetColumns.length - 2,
                                                                        'text-right': ['unit_cost', 'unit_mark_up', 'builder_cost', 'discount', 'owner_price'].includes(col.field),
                                                                        'text-center': ['unit_quantity', 'labor'].includes(col.field)
                                                                    }"
                                                                >
                                                                    <label class="d-block m-0 p-0" for="chk-all">
                                                                        <input  
                                                                            v-if="index === 0"
                                                                            class="checkbox_animated" 
                                                                            id="chk-all" 
                                                                            type="checkbox"
                                                                            v-model="allChecked"
                                                                            :checked="allChecked"
                                                                            @change="toggleAll">{{ col.headerName }}
                                                                    </label>
                                                                </th>
                                                            </template>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(items, row_index) in proposalForm.worksheet" :key="items.proposal_item_id">
                                                            <template v-for="(col, index) in worksheetColumns" :key="col.field">
                                                                <td 
                                                                    :style="{ width: col.width + 'px' }"
                                                                    :class="{
                                                                        'left-sticky-title': index === 0,
                                                                        'sticky': index === worksheetColumns.length - 1, 
                                                                        'sticky-second-last': index === worksheetColumns.length - 2,
                                                                        'text-right': ['unit_cost', 'unit_mark_up', 'builder_cost', 'discount', 'owner_price'].includes(col.field),
                                                                        'text-center': ['unit_quantity', 'labor'].includes(col.field),
                                                                        'f-w-600': ['builder_cost', 'owner_price'].includes(col.field)
                                                                    }"
                                                                >
                                                                    <label v-if="index === 0" :for="'chk-ani-' + items.proposal_item_id + '-' + row_index" class="d-block m-0 p-0">
                                                                        <input 
                                                                            class="checkbox_animated" 
                                                                            :id="'chk-ani-' + items.proposal_item_id + '-' + row_index" 
                                                                            type="checkbox"
                                                                            :value="items.proposal_item_id + '_' + row_index"
                                                                            v-model="checkedItems"
                                                                        >{{ items[col.field] }}
                                                                    </label>
                                                                    <a v-else>{{ items[col.field] }}</a>
                                                                </td>
                                                            </template>
                                                        </tr>
                                                        <tr class="text-right f-w-700" style="background-color: #e6edef !important;">
                                                            <td :colspan="worksheetColumns.length - 3"></td>
                                                            <td class="sticky-total">Total: </td>
                                                            <td class="sticky-second-last" style="background-color: #e6edef !important;">{{ sumBuilderCost }}</td>
                                                            <td class="sticky" style="background-color: #e6edef !important;">{{ sumOwnerPrice }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="pills-extra-details" role="tabpanel" aria-labelledby="pills-extra-details-tab">
                                    <hr/>
                                    <div class="col-md-12 mt-3">
                                        <div class="mb-3">
                                            <label class="form-label f-w-600">Internal Notes</label>
                                            <textarea class="form-control border-success" type="text" placeholder="Enter text here..." name="internal_notes"  v-model="proposalForm.internal_notes" :disabled="processing"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="mb-3">
                                            <label class="form-label f-w-600">Introductory Text</label>
                                            <SummerNote 
                                                :modelValue="proposalForm.introductory_text" 
                                                @update:modelValue="val => proposalForm.introductory_text = val"
                                                :disabled="processing"></SummerNote>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="mb-3">
                                            <label class="form-label f-w-600">Closing Text</label>
                                            <SummerNote 
                                                :modelValue="proposalForm.closing_text" 
                                                @update:modelValue="val => proposalForm.closing_text = val"
                                                :disabled="processing"></SummerNote>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-payment" role="tabpanel" aria-labelledby="pills-payment-tab">
                                    <hr/>
                                    <div class="container" v-if="fetchingData">
                                        <div class="col-md-12 d-flex flex-column align-items-center">
                                            <div style="width: 200px; height: 130px;">
                                                <div class="loader-box">
                                                    <div class="loader-17"></div>
                                                </div>
                                            </div>
                                            <h3 class="text-dark text-center">Loading...</h3>
                                        </div>
                                    </div>
                                    <div class="container" v-else-if="proposalForm.payment_request.deposit == 0">
                                        <div class="col-md-12 d-flex flex-column align-items-center">
                                            <div style="width: 200px; height: 200px;">
                                                <!-- <img src="../../../assets/sales/payment-request.png" alt=""> -->
                                            </div>
                                            <h3 class="text-dark text-center">Online Payment Details</h3>
                                            <p class="sub-content text-center" v-if="proposalForm.worksheet.length != 0">You haven't requested any payment details yet, request one now.</p>
                                            <p class="sub-content text-center" v-else>Can't setup payment details with empty worksheet.</p>
                                            <a class="btn btn-outline-primary" style="width: auto;" data-bs-toggle="modal" data-original-title="addPayment" data-bs-target="#addPayment" v-if="proposalForm.worksheet.length != 0">Add Payment Request</a>
                                        </div>
                                    </div>
                                    <div class="container" v-else>
                                        <div class="card m-0 p-0 border-none">                            
                                            <div class="card-header m-0 p-0 mb-5 mt-3 d-flex justify-content-between text-dark">
                                                <h4 class="card-title mb-0">Payment Details</h4>
                                                <a class="btn btn-outline-danger" style="height: 35px !important;" data-bs-toggle="modal" data-original-title="addPayment" data-bs-target="#addPayment">Edit Payment Details</a>
                                            </div>
                                            <div class="card-body m-0 p-0 pt-2 text-dark">
                                                <div class="mb-3 row">
                                                    <div class="col-md-6 d-flex">
                                                        <label class="f-w-700 pr-3" for="inputEmail3">Job Total Value:</label>
                                                        <label class="f-w-500 text-muted" for="inputEmail3">{{ formatPaymentTotal(proposalForm.payment_request.deposit) }}</label>
                                                    </div>
                                                    <div class="col-md-6 d-flex">
                                                        <label class="f-w-700 pr-3" for="inputEmail3">Payment Type:</label>
                                                        <label class="f-w-500 text-muted" for="inputEmail3">{{ formatPaymentType(proposalForm.payment_request.deposit_type, proposalForm.payment_request.percentage) }}</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <div class="col-md-6 d-flex">
                                                        <label class="f-w-700 pr-3" for="inputEmail3">Payment Due:</label>
                                                        <label class="f-w-500 text-muted" for="inputEmail3">{{ formatPaymentDue(proposalForm.payment_request.payment_due, proposalForm.payment_request.payment_due_day) }}</label>
                                                    </div>
                                                    <div class="col-md-6 d-flex">
                                                        <label class="f-w-700 pr-3" for="inputEmail3">Payment Method:</label>
                                                        <label class="f-w-500 text-muted" for="inputEmail3">{{ formatPaymentMethod(proposalForm.payment_request.payment_method) }}</label>
                                                    </div>
                                                </div>
                                                <hr/>
                                                <div class="d-flex justify-content-end py-3">
                                                    <div class="input-group pill-input-group mr-2">
                                                        
                                                        <input value="Stage Count #" class="input-group-text stage-input-label" type="text" aria-label="Amount (to the nearest dollar)" disabled>
                                                        <span  class="input-group-text decrement-button" @click="decrementStage">-</span>
                                                        <input v-model="proposalForm.payment_request.stages" class="form-control stage-input" type="text" aria-label="Amount (to the nearest dollar)" disabled>
                                                        
                                                        <span class="input-group-text increment-button" @click="incrementStage">+</span>
                                                    </div>
                                                    <a class="btn btn-outline-success float-right" style="height: 35px !important;" @click="handleAddStagePayment" data-bs-toggle="modal" data-original-title="addStagePayment" data-bs-target="#addStagePayment">Add Stage Payment</a>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <div class="col-12">
                                                        <li 
                                                            class="list-group-item d-flex m-0 p-0" style="background-color: #E6EDEF; color: #242934;"
                                                        >
                                                            <span class="p-3 custom-border f-w-600" style="width: 15%;">Action</span>
                                                            <span class="p-3 flex-grow-1 custom-border f-w-600">Stage Title</span>
                                                            <span class="p-3 custom-border f-w-600" style="width: 20%;">Contract Value</span>
                                                            <span class="p-3 custom-border f-w-600" style="width: 20%;">Stages</span>
                                                            <span class="p-3 custom-border f-w-600" style="width: 20%;">Payment Amount</span>
                                                        </li>
                                                    </div>
                                                    <template v-for="stage in proposalForm.payment_request.stages" :key="'stage-' + stage">
                                                        <div class="col-12">
                                                            <div style="height: 3px; background-color: #242934" v-if="stage != 1"></div>
                                                            <li v-if="(proposalForm.payment_request.stage_payments[stage-1]) ? proposalForm.payment_request.stage_payments[stage-1].length == 0 : true " class="list-group text-center py-2 f-w-700">Empty Stage {{ stage }}</li>
                                                            <draggable class="list-group" :list="proposalForm.payment_request.stage_payments[stage-1]" group="people" @change="log" handle=".handle" :stage="stage">
                                                                <template v-for="(element, index) in proposalForm.payment_request.stage_payments[stage-1]" :key="'element-' + element.proposal_billing_stage_id + '-' + index">
                                                                    <li class="list-group-item d-flex m-0 p-0">
                                                                        <span class="p-3 f-w-600" style="width: 15%;">
                                                                            <i class="icofont icofont-ui-delete cursor-pointer text-danger" @click="handleDeleteStage(stage, index)"></i>
                                                                            <i class="icofont icofont-edit cursor-pointer text-success" @click="handleUpdateStage(element, index, stage)"  data-bs-toggle="modal" data-original-title="addStagePayment" data-bs-target="#addStagePayment"></i>
                                                                            <i class="icofont icofont-drag handle cursor-pointer text-primary"></i>
                                                                        </span>
                                                                        <span class="p-3 flex-grow-1">{{ element.stage_name }}</span>
                                                                        <span class="p-3" style="width: 20%;">{{ formatCurrency(element.stage_amount) }}</span>
                                                                        <span class="p-3" style="width: 20%;">Stage {{ stage }}</span>
                                                                        <span class="p-3" style="width: 20%;"></span>
                                                                    </li>
                                                                    <div class="payment-amount-style f-w-600">{{ formatCurrency(calculateStageTotal(stage)) }}</div>
                                                                </template>
                                                            </draggable>
                                                        </div>
                                                    </template>
                                                    <li class="list-group-item d-flex m-0 p-0" style="background-color: #E6EDEF; color: #242934;">       
                                                        <span class="p-3 flex-grow-1 text-right custom-border">Total Stage Payment: </span>
                                                        <span class="p-3 custom-border f-w-600 text-center" style="width: 20%;">{{ formatCurrency(grandTotal) }}</span>
                                                    </li>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-preview" role="tabpanel" aria-labelledby="pills-preview-tab">
                                    <hr/><p class="mb-0 m-t-30 f-w-700">Verify the PDF content and complete the form to send this proposal out for signature.</p>
                                    
                                    <div class="col-md-12 mt-3">
                                        <div class="mb-3">
                                            <label class="form-label f-w-600">What to Display to Lead</label>                                            
                                            <Select2 
                                                v-model="defaultPdfContent"
                                                :className="'container-style-outlined-no-hover'"
                                                :placeholder="'Select Items to show in proposal PDF'" 
                                                :id="'proposal-pdf-content'"
                                                :purpose="'multiple-select'"
                                                :items="pdfContentItems"
                                                :disabled="processing"
                                                :hasChecks="true"
                                            />
                                        </div>
                                    </div>
                                    <div class="row m-0 p-0 pt-4">
                                        <div class="col-md-8">
                                            <div v-if="generatingPDF">
                                                GENERATING PDF PLEASE WAIT....
                                            </div>
                                            <iframe class="border-success" ref="pdfIframe" width="100%" height="700px"></iframe>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="tab-content m-0" id="pills-icontabContent">
                                                <div class="tab-pane fade active show" id="pills-preview-email" role="tabpanel" aria-labelledby="pills-preview-email-tab">
                                                    <div class="row">
                                                        <div class="btn btn-primary px-2 ml-3 mb-3 cursor-none" style="width: auto">Email Recipient</div>
                                                        <div class="mb-3 col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label f-w-600">Recepient</label>
                                                                <Select2 
                                                                    ref="select2Recepient"
                                                                    v-model="selectedRecepient"
                                                                    :className="'container-style-outlined-no-hover'"
                                                                    :placeholder="'Enter email here...'" 
                                                                    :id="'proposal-recepient'"
                                                                    :purpose="'multiple-select'"
                                                                    :items="userData"
                                                                    :isLoading="userLoading"
                                                                    :disabled="processing"
                                                                    :type="'email'"
                                                                />
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label f-w-600">Cc</label>
                                                                <Select2 
                                                                    ref="select2Cc"
                                                                    v-model="selectedCc"
                                                                    :className="'container-style-outlined-no-hover'"
                                                                    :placeholder="'Enter email here...'" 
                                                                    :id="'proposal-cc'"
                                                                    :purpose="'multiple-select'"
                                                                    :items="userData"
                                                                    :isLoading="userLoading"
                                                                    :disabled="processing"
                                                                    :type="'email'"
                                                                />
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="btn btn-primary px-2 ml-3 mb-3 mt-2 cursor-none" style="width: auto">SMS Preview</div>
                                                        <div class="mb-3 col-md-12">
                                                            <label class="form-label f-w-600">Send To</label>
                                                                <Select2 
                                                                    ref="select2Numbers"
                                                                    v-model="selectedNumber"
                                                                    :className="'container-style-outlined-no-hover'"
                                                                    :placeholder="'Enter phone here...'" 
                                                                    :id="'proposal-numbers'"
                                                                    :purpose="'multiple-select'"
                                                                    :items="userData"
                                                                    :isLoading="userLoading"
                                                                    :disabled="processing"
                                                                    :type="'phone'"
                                                                />
                                                        </div>
                                                        <div class="mb-3 col-md-12">
                                                            <div class="d-flex justify-content-between">
                                                                <label class="form-label f-w-600">Message Content</label>
                                                                <label class="form-label f-w-600 cursor-pointer text-primary" @click="handleChooseMessageTemplate">Choose Template</label>
                                                            </div>
                                                            <textarea class="form-control border-success" type="text" placeholder="Enter message here..." name="sms_content" v-model="messageContent"></textarea>
                                                        </div>
                                                        <div class="mb-3 col-md-12">
                                                            <label class="form-label f-w-600">Preview</label>
                                                            <div class="b-r-5 p-4" style="background-color: #d6d6d6; height: auto;">
                                                                <label v-if="messageContent == ''">Type Anything to the content</label>
                                                                <SMSChatBubble :message="messageContent" v-else/>
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
                        <div class="card-footer text-end d-flex justify-content-between" v-if="leadForm.lead_id != 0">
                            <div></div>
                            <div class="form-footer text-end position relative">
                                <a 
                                    class="btn btn-primary send-options-toggle" 
                                    :disabled="processing" 
                                    style="color: white;">
                                    Create Change Order
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="selectLeads" tabindex="-1" role="dialog" aria-labelledby="selectLeads" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select Lead</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <input v-model="searchTerm" type="text" class="form-control" placeholder="Search for a lead...">

                    <div class="progress m-10" v-if="isLoading">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary" role="progressbar" style="width: 100%" value="100" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <div v-else-if="leads.length">
                        <div v-for="lead in leads" :key="lead.id" class="lead-management-item" @click="populateLeadFormWithLeadData(lead)" data-bs-dismiss="modal">
                            <div class="d-flex flex-column border p-3 cursor-pointer list-group-item-action">
                                <label class="f-w-600 text-success cursor-pointer">{{ lead.opportunity_title }}</label>
                                <small class="status">Address: {{ lead.street_address + ' '  + lead.city + ' ' + lead.state + ' ' + lead.zip_code }}</small>
                            </div>
                        </div>
                    </div>

                    <div v-else class="p-3 text-center">
                        <p class="text-muted" v-if="searchTerm != ''">No results found for "{{ searchTerm }}"</p>
                        <p class="text-muted" v-else>No Leads available.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="px-3 py-2" style="width: 100%;">
                        <nav class="d-flex justify-content-between">
                            <a class="mt-1">Showing <b>{{ startingEntry }}</b> to <b>{{ endingEntry }}</b> out of <b>{{ totalEntries }}</b> entries</a>
                            <ul class="pagination justify-content-end pagination-primary">
                                <li class="page-item" :class="{ 'disabled': (currentPage <= 1) || isLoading }">
                                    <a class="page-link" href="javascript:void(0)" @click="changePage(currentPage - 1)">Previous</a>
                                </li>

                                <li class="page-item" v-for="page in pagesToShow" :key="page" :class="[{ 'active': page === currentPage }, { 'disabled': isLoading }]">
                                    <a class="page-link" href="javascript:void(0)" @click="changePage(page)">{{ page }}</a>
                                </li>

                                <li class="page-item" :class="{ 'disabled': (currentPage >= totalPages)|| isLoading}">
                                    <a class="page-link" href="javascript:void(0)" @click="changePage(currentPage + 1)">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="addPayment" tabindex="-1" role="dialog" aria-labelledby="addPayment" aria-hidden="true" style="overflow: hidden">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body p-0 m-0">
                    <div class="card p-0 m-0">
                        <div class="card-header border">
                            <h5>Online Payment Options</h5>
                            <span>Use these settings to request payment upon or after approval of this proposal.</span>
                        </div>
                        <div class="card-body p-4" style="background-color: #f5f7fb; overflow-y: auto; max-height: 65vh;">
                            <div class="card m-0 p-0">
                                <div class="card-body m-0 p-0 px-5 py-5">
                                    <h5>Proposal Total: <span class="f-w-700">{{ sumOwnerPrice }}</span></h5>
                                    <hr/>

                                    <div class="row m-0 p-0">
                                        <div class="col-md-12 p-0 mb-3">
                                            <label class="form-label f-w-600 p-0">Payment Type</label>
                                            <div class="btn-group col-md-12 mb-3" role="group" aria-label="Basic example">
                                                <button class="btn" 
                                                        :class="togglePaymentAmount == 'amount' ? 'btn-primary text-white' : 'btn-outline-primary'" 
                                                        type="button" 
                                                        @click="togglePaymentAmountValue('amount')">Amount</button>
                                                <button class="btn" 
                                                        :class="togglePaymentAmount == 'percent' ? 'btn-primary text-white' : 'btn-outline-primary'" 
                                                        type="button" 
                                                        @click="togglePaymentAmountValue('percent')">Percent</button>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 row m-0 p-0 mb-5" v-if="togglePaymentAmount == 'amount'">
                                            <label class="form-label f-w-600 p-0">Payment Amount</label>
                                            <div class="input-group p-0">
                                                <span class="input-group-text border-success" style="font-size: 12px !important;">$</span>
                                                <input class="form-control border-success" @input="processInput" aria-label="Amount (to the nearest dollar)" v-model="proposalForm.payment_request.deposit">
                                            </div>
                                            <div class="text-danger" v-if="modalBillingAmountError">Amount is Required</div>
                                        </div>
                                        
                                        <div class="col-md-12 row m-0 p-0 mb-5" v-else>
                                            <div class="col-md-5 p-0 pr-2">
                                                <label class="form-label f-w-600">Percent of Total</label>
                                                <div class="input-group">
                                                    <input class="form-control border-success" @input="processInput" aria-label="Amount (to the nearest dollar)" v-model="proposalForm.payment_request.percentage">
                                                    <span class="input-group-text border-success" style="font-size: 12px !important;">%</span>
                                                </div>
                                            </div>
                                            <div class="col-md-7 p-0">
                                                <label class="form-label f-w-600">Payment Amount</label>
                                                <label class="form-control f-w-500 border-success">{{ computePercentage() }}</label>
                                            </div>
                                            <div class="text-danger" v-if="modalBillingAmountError">Amount is Required</div>
                                        </div>  

                                        <div class="col-md-12 row m-0 p-0 mb-3">
                                            <label class="form-label f-w-600 p-0">Payment Due</label>
                                            <div class="col mt-1">
                                                <label class="d-block" for="pd-upon">
                                                    <input class="radio_animated" id="pd-upon" type="radio" name="rdo-pd" checked="" value="upon" v-model="proposalForm.payment_request.payment_due">Upon approval of proposal
                                                </label>
                                                <div class="d-flex align-items-center">
                                                    <label class="d-block mr-3" for="pd-after">
                                                            <input class="radio_animated" id="pd-after" type="radio" name="rdo-pd" value="after" v-model="proposalForm.payment_request.payment_due">After approval of proposal
                                                    </label>
                                                    <template v-if="proposalForm.payment_request.payment_due === 'after'">
                                                        <div class="col-md-1 row m-0 p-0 mr-3">
                                                            <input class="form-control border-success" type="number" min="1" v-model="proposalForm.payment_request.payment_due_day">
                                                        </div>
                                                        <label class="col-md-4" for="pd-after"># of Days After Approval</label>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div class="col-md-12 row m-0 p-0">
                                            <label class="form-label f-w-600 p-0">Payment Method</label>
                                            <div class="col mt-1">
                                                <label class="d-block" for="pm-cc">
                                                    <input class="radio_animated" id="pm-cc" type="radio" name="rdo-pm" checked="" value="credit" v-model="proposalForm.payment_request.payment_method">Credit Card
                                                </label>
                                                <label class="d-block" for="pm-ach">
                                                    <input class="radio_animated" id="pm-ach" type="radio" name="rdo-pm" value="ach" v-model="proposalForm.payment_request.payment_method">ACH
                                                </label>
                                                <label class="d-block" for="pm-cc-or-ach">
                                                    <input class="radio_animated" id="pm-cc-or-ach" type="radio" name="rdo-pm" value="credit-ach" v-model="proposalForm.payment_request.payment_method">Credit Card ACH
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary float-right" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addStagePayment" tabindex="-1" role="dialog" aria-labelledby="addStagePayment" aria-hidden="true" style="overflow: hidden">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body p-0 m-0">
                    <div class="card p-0 m-0">
                        <div class="card-header border">
                            <h5>{{ proposalStagePaymentForm.update_index == -1 ? 'Add' : 'Update'}} Stage Payment</h5>
                            <span v-if="proposalStagePaymentForm.update_index == -1">This will be added directly to the current last stage.</span>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="card-body p-4" style="background-color: #f5f7fb; overflow-y: auto; max-height: 65vh;">
                            <div class="card m-0 p-0">
                                <div class="card-body m-0 p-0 px-5 py-5">

                                    <div class="row m-0 p-0">
                                        
                                        <div class="col-md-12 row m-0 p-0 mb-3">
                                            <label class="form-label f-w-600 p-0">Stage Title</label>
                                            <input class="form-control border-success" type="text" v-model="proposalStagePaymentForm.stage_name">
                                            <div class="text-danger" v-if="modalStageTitleError">Amount is Required</div>
                                        </div>
                                        <div class="col-md-12 row m-0 p-0 mb-3">
                                            <label class="form-label f-w-600 p-0">Stage Amount</label>
                                            <div class="input-group p-0">
                                                <span class="input-group-text border-success" style="font-size: 12px !important;">$</span>
                                                <input class="form-control border-success" @input="processInput" aria-label="Amount (to the nearest dollar)" v-model="proposalStagePaymentForm.stage_amount">
                                            </div>
                                            <div class="text-danger" v-if="modalStageAmountError">Amount is Required</div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-secondary float-right" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary mr-2 float-right" @click="handleStagePaymentSubmit(proposalStagePaymentForm.update_stage, proposalStagePaymentForm.update_index)">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <CostItemListModal 
        @selectedItems="handleSelectedCostItems"
        @selectedItem="handleSelectedCostItem"
        :reloadData="reloadCostItems"/>
    <CostItemModal
        :type="costItemType"
        @result="handleChangeCostItem" 
        @onClose="resetSelectedCostItem" 
        :can_delete="true"
        :selected="selectedItem"
        @onSubmit="handleNewCostItem"
    />
</template>
<script setup>
    import { useForm, usePage } from "@inertiajs/vue3";
    import { Inertia } from '@inertiajs/inertia';
    import { ref, computed, onMounted, watch, onBeforeUnmount, nextTick } from 'vue';
    import axios from 'axios';
    import Swal from 'sweetalert2';
    import SummerNote from '../../components/Summernote.vue';
    import html2pdf from "html2pdf.js";
    // import { VCombobox } from 'vuetify/lib/components/VCombobox';
    import { VueDraggableNext } from 'vue-draggable-next';
    import SMSChatBubble from '../../components/SMSChatBubble.vue';
    import CostItemListModal from '../../components/modals/CostItemListModal.vue';
    import CostItemModal from '../../components/modals/CostItemModal.vue';
    import Select2 from './../../components/Select2.vue';
    import Breadcrumb from '../../components/Breadcrumb.vue'

    const draggable = VueDraggableNext;
    const page = usePage();
    const selected_proposal = ref('');
    const proposal_option_loading = ref(false);
    const show_proposal_option = ref(false);
    const proposal_options = ref([]);

    //FOR PREVIEW
    const select2Recepient = ref(null);
    const select2Cc = ref(null);
    const select2Numbers = ref(null);
    const generatingPDF = ref(false);
    const messageContent = ref('');
    const emailSubject = ref(`Your Custom Proposal from ${page.props.company_name} Awaits!`);
    const selectedRecepient = ref([page.props.lead.lead_customer.cust_id + '']);
    const selectedCc = ref([page.props.user_id + '']);
    const selectedNumber = ref([page.props.lead.lead_customer.cust_id + '']);
    const userData = ref([]);
    const userLoading = ref(false);
    const proposalHtml = ref('');
    const defaultPdfContent = ref(['Item Title', 'Description']);
    const pdfContentItems = ref([
        { id: 'Item Title', text: 'Item Title'},
        { id: 'Description', text: 'Description'},
        { id: 'Qty / Unit', text: 'Qty / Unit'},
        { id: 'Unit Cost', text: 'Unit Cost'},
        { id: 'Builder Total Cost', text: 'Builder Total Cost'},
        { id: 'Markup', text: 'Markup'},
        { id: 'Markup Amount', text: 'Markup Amount'},
        { id: 'Unit Price', text: 'Unit Price'},
    ]);

    //GENERAL
    const proposalStatus = ref('NEW ENTRY');
    const proposalStatusColor = ref('badge-secondary');
    const processing = ref(false);
    const proposalData = ref(page.props.proposal);
    const fetchingData = ref(false);
    const closeSendOption = ref(false);

    //FOR PAYMENT
    const modalStageTitleError = ref(false);
    const modalStageAmountError = ref(false);
    const log = (event) => {
        console.log(event)
    }
    
    const incrementStage = () => {
        proposalForm.payment_request.stages++;
        proposalForm.payment_request.stage_payments.push([]);
    }
    const decrementStage = () => {
        if (proposalForm.payment_request.stages > 1){
            const check = proposalForm.payment_request.stage_payments[(proposalForm.payment_request.stages - 1)].length;
            if(check == 0){
                proposalForm.payment_request.stages--;
                proposalForm.payment_request.stage_payments.pop();
            }else{
                Swal.fire({
                    title: 'Not EMPTY Stage!',
                    text: "You have stage items in this stage, removing the stage means removing the items in it, do you wish to proceed?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Proceed'
                }).then((result) => {
                    if (result.isConfirmed) {
                        proposalForm.payment_request.stages--;
                        proposalForm.payment_request.stage_payments.pop();
                    }
                });
            }
        }
    }

    //FOR LEAD MODAL
    const isLoading = ref(false);
    const currentPage = ref(1);
    const totalPages = ref(0);
    const startingEntry = ref(0);
    const endingEntry = ref(0);
    const totalEntries = ref(0);
    const leads = ref([]);
    const searchTerm = ref('');

    //FOR LEAD DETAILS
    const showMore = ref(true);
    const salesPeople = ref('N/A');
    const tags = ref('N/A');
    const sources = ref('N/A');
    const jobTypes = ref('N/A');
    const pdfIframe = ref(null);
    const leadData = ref(page.props.lead); 
    
    //FOR PROPOSAL ITEM MODAL
    const ownerQuantityChecked = ref(false);
    const ownerPriceChecked = ref(false);
    const modalItemTitleError = ref(false);
    const reloadCostItems = ref(false);
    const costItemType = ref('default');
    const selectedItem = ref(null);

    //FOR PAYMENT REQUEST MODAL
    const togglePaymentAmount = ref('amount');
    const modalBillingAmountError = ref(false);
    
    //FOR WORKSHEET
    const sumBuilderCost = ref(0.0);
    const sumOwnerPrice = ref(0.0);
    const estimatedProfit = ref(0.0);
    const totalMargin = ref(0.0);
    const totalMarkup = ref(0.0);
    const showPopoverBreakDown = ref(false);
    const showImportOptions = ref(false);
    const checkedItems = ref([]);
    const itemsChange = ref(false);
    let initialWorksheet = ref([]);
    const worksheetColumns = ref([
        { headerName: "Item", field: "title", width: 200 },
        { headerName: "Unit Cost", field: "unit_cost", width: 150 },
        { headerName: "Unit", field: "unit", width: 100 },
        { headerName: "Quantity", field: "unit_quantity", width: 100 },
        { headerName: "Mark Up", field: "unit_mark_up", width: 150 },
        { headerName: "Discount", field: "discount", width: 100 },
        { headerName: "Labor Type", field: "labor", width: 100 },
        { headerName: "Builder Cost", field: "builder_cost", width: 150 }, // I added a placeholder since 'Builder Cost' field wasn't provided
        { headerName: "Owner Price", field: "owner_price", width: 150 }, // Same here for 'Owner Price'
    ]);


    const pagesToShow = computed(() => {
        let startPage = Math.max(1, currentPage.value - 1);
        let endPage = Math.min(totalPages.value, currentPage.value + 1);
        return Array.from({ length: endPage - startPage + 1 }, (_, index) => startPage + index);
    });


    function changePage(pageNumber) {
        if (pageNumber >= 1 && pageNumber <= totalPages.value) {
            currentPage.value = pageNumber;
        }
        fetchLeads(currentPage.value, searchTerm.value);
    }

    const leadForm = useForm({
        lead_id: 0,
        cust_id: 0,
        opportunity_title: '',
        street_address: '',
        city: '',
        state: '',
        zipcode: '',
        opportunity_phone: '',
        status: 'open',
        description: '',
        cost_of_lead: 0,
        created_by: '',
        updated_by: ''
    });

    const form = useForm({
        cust_id: 0,
        first_name: '',
        last_name: '',
        display_name: '',
        phone: '',
        cell_phone: '',
        email: '',
        company: '',
        street_address: '',
        city: '',
        state: '',
        zip_code: '',
    });

    const proposalForm = useForm({
        proposal_id: 0,
        lead_id: 0,
        title: '',
        approval_deadline: '',
        status: 'Not Sent',
        internal_notes: '',
        introductory_text: '',
        closing_text: '',
        worksheet: [],
        payment_request: {
            proposal_billing_id: 0,
            deposit: 0.0,
            deposit_type: 'amount',
            payment_due: 'upon',
            stages: 1,
            payment_due_day: 1,
            payment_method: 'credit',
            percentage: 0,
            stage_payments: [[]]
        }
    });
    let initialData = ref({ ...proposalForm });
    let initialPaymentRequest = ref({ ...proposalForm.payment_request });
    const initialPaymentStages = ref([[]]);

    const proposalItemForm = useForm({
        proposal_item_id: 0,
        proposal_id: 0,
        title: '',
        description: '',
        internal_notes: '',
        unit_cost: 0.0,
        unit: '',
        unit_quantity: 1,
        unit_mark_up: 0.0,
        unit_mark_up_type: '%',
        status: 1,
        labor: 0,
        discount: 0.0,
        discount_type: '%'
    });
    const modaBuilderCostTotal = computed(() => {
        const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            });
        return formatter.format(proposalItemForm.unit_cost * proposalItemForm.unit_quantity);
    });    
    const modalOwnerPriceTotal = computed(() => {
        const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            });
        const builder_cost = (proposalItemForm.unit_cost * proposalItemForm.unit_quantity);
        return formatter.format(builder_cost + getMarkup(proposalItemForm.unit_mark_up_type, proposalItemForm.unit_mark_up, proposalItemForm.unit_quantity, builder_cost));
    });

    const proposalStagePaymentForm = useForm({
        proposal_billing_stage_id: 0,
        proposal_billing_id: 0,
        stage_name: '',
        stage_number: (proposalForm.payment_request.stages - 1),
        stage_amount: 0.0,
        update_index: -1,
        update_stage: 0
    });

    function togglePaymentAmountValue(type){
        togglePaymentAmount.value = type;
        proposalForm.payment_request.deposit_type = type;

        if(type === 'amount'){
            proposalForm.payment_request.percentage = 0;
        }
    }

    function toggleBreakDownPopover() {
        showPopoverBreakDown.value = !showPopoverBreakDown.value;
    }

    function toggleSendOptions() {
        closeSendOption.value = !closeSendOption.value;
    }

    function toggleImportPopover() {
        showImportOptions.value = !showImportOptions.value;
    }

    const handleDocumentClick = (event) => {
        if (!event.target.closest('.break-pop-over')) {
            showPopoverBreakDown.value = false;
        }
        if (!event.target.closest('.send-options-toggle')) {
            closeSendOption.value = false;
        }
        if (!event.target.closest('.import-pop-over')) {
            showImportOptions.value = false;
        }
                
    };

    const processInput = (event) => {
        let value = event.target.value;

        // Ensure the value is a number with at most two decimal places
        if (!/^\d*\.?\d{0,2}$/.test(value)) {
            event.target.value = value.substring(0, value.length - 1);
        }
    }

    function populateProposalData(proposalData){
        fetchingData.value = true;
        if(proposalData){
            proposalForm.proposal_id = proposalData.proposal_id;
            proposalForm.title = proposalData.title;
            proposalForm.approval_deadline = proposalData.approval_deadline;
            proposalForm.status = proposalData.status;
            proposalForm.internal_notes = proposalData.internal_notes;
            proposalForm.introductory_text = proposalData.introductory_text;
            proposalForm.closing_text = proposalData.closing_text;

            if(proposalForm.status === 'Not Sent'){
                proposalStatus.value = 'NOT SENT';
                proposalStatusColor.value = 'badge-info';
            }else if(proposalForm.status === 'Approved'){
                proposalStatus.value = 'APPROVED';
                proposalStatusColor.value = 'badge-primary';
            }else if(proposalForm.status === 'Sent'){
                proposalStatus.value = 'SENT';
                proposalStatusColor.value = 'badge-warning';
            }
            getProposalItems();
            getProposalPaymentRequest();

        }else{
            resetProposal()
            proposalForm.title = leadForm.opportunity_title;
            proposalForm.lead_id = leadForm.lead_id;
            proposalStatus.value = 'NEW ENTRY';
            proposalStatusColor.value = 'badge-secondary';
            sumBuilderCost.value = 0.0;
            sumOwnerPrice.value = 0.0;
            estimatedProfit.value = 0.0;
            totalMargin.value = 0.0;
            totalMarkup.value = 0.0;
            
            initialData = ref({ ...proposalForm });
            initialWorksheet.value = proposalForm.worksheet;
            initialPaymentRequest = {
                proposal_billing_id: 0,
                deposit: 0.0,
                deposit_type: 'amount',
                payment_due: 'upon',
                payment_due_day: 1,
                payment_method: 'credit',
                percentage: 0,
                stage_payments: [[]]
            }
            initialPaymentStages.value = [[]];
            
            fetchingData.value = false;
        }
    }

    function resetProposal(){
        proposalForm.proposal_id = 0;
        proposalForm.lead_id = 0;
        proposalForm.title = '';
        proposalForm.approval_deadline = '';
        proposalForm.status = 'Not Sent';
        proposalForm.internal_notes = '';
        proposalForm.introductory_text = '';
        proposalForm.closing_text = '';
        proposalForm.worksheet = [];
    }

    function resetProposalItem(){
        proposalItemForm.proposal_item_id = 0;
        proposalItemForm.proposal_id = 0;
        proposalItemForm.title = '';
        proposalItemForm.description = '';
        proposalItemForm.internal_notes = '';
        proposalItemForm.unit_cost = 0.0;
        proposalItemForm.unit = '';
        proposalItemForm.unit_quantity = 1;
        proposalItemForm.unit_mark_up = 0.0;
        proposalItemForm.unit_mark_up_type = '%';
        proposalItemForm.status = 1;
        proposalItemForm.labor = 0;
        proposalItemForm.discount = 0.0;
        proposalItemForm.discount_type = '%';
    }

    function setProposalItem(item){
        if(item){
            proposalItemForm.proposal_item_id = item.proposal_item_id;
            proposalItemForm.proposal_id = item.proposal_id;
            proposalItemForm.title = item.title;
            proposalItemForm.description = item.description;
            proposalItemForm.internal_notes = item.internal_notes;
            proposalItemForm.unit_cost = item.unit_cost.replace(/[$,]/g, '');
            proposalItemForm.unit = item.unit;
            proposalItemForm.unit_quantity = item.unit_quantity;
            proposalItemForm.unit_mark_up = item.unit_mark_up.replace(/[^0-9.]/g, '');
            proposalItemForm.unit_mark_up_type = item.unit_mark_up_type;
            proposalItemForm.status = item.status;
            proposalItemForm.labor = item.labor;
            proposalItemForm.discount = item.discount.replace(/[$,]/g, '');
            proposalItemForm.discount_type = item.discount_type;
        }else{
            resetProposalItem();
        }
    }

    function populateLeadFormWithLeadData(leadData) {
        if (leadData) {
            leadForm.lead_id = leadData.lead_id || 0;
            proposalForm.lead_id = leadForm.lead_id;
            leadForm.cust_id = leadData.cust_id || 0;
            leadForm.opportunity_title = leadData.opportunity_title || '';
            proposalForm.title = leadForm.opportunity_title;
            leadForm.street_address = leadData.street_address || '';
            leadForm.city = leadData.city || '';
            leadForm.state = leadData.state || '';
            leadForm.zipcode = leadData.zipcode || '';
            leadForm.opportunity_phone = leadData.opportunity_phone || '';
            leadForm.status = leadData.status || 'open';
            leadForm.description = leadData.description || '';
            leadForm.cost_of_lead = leadData.cost_of_lead || 0;
            leadForm.created_by = leadData.created_by || '';
            leadForm.updated_by = leadData.updated_by || '';

            show_proposal_option.value = true;
            populateFormWithCustomer(leadData.lead_customer);
            getSalesperson(leadData.sales_people);
            getTags(leadData.tags);
            getSources(leadData.sources);
            getJobTypes(leadData.job_types);
            getLeadProposals();
        }
    }

    function populateFormWithCustomer(selectedCustomer) {
        leadForm.cust_id = selectedCustomer.cust_id;
        form.cust_id = selectedCustomer.cust_id;
        form.first_name = selectedCustomer.first_name;
        form.last_name = selectedCustomer.last_name;
        form.display_name = selectedCustomer.display_name;
        form.phone = selectedCustomer.phone;
        form.cell_phone = selectedCustomer.cell_phone;
        form.email = selectedCustomer.email;
        form.company = selectedCustomer.company;
        form.street_address = selectedCustomer.street_address;
        form.city = selectedCustomer.city;
        form.state = selectedCustomer.state;
        form.zip_code = selectedCustomer.zip_code;
    }

    function getSalesperson(salesPeopleArray){
        salesPeople.value = salesPeopleArray.map(salesperson => `
            <span class="badge badge-primary mb-1">${salesperson.user.display_name}</span>
        `).join('');
    }
    
    function getTags(tagsArray){
        tags.value = tagsArray.map(tag => `
            <span class="badge badge-primary mb-1">${tag.tag.tags_name}</span>
        `).join('');
    }

    
    function getSources(sourcesArray){
        sources.value = sourcesArray.map(source => `
            <span class="badge badge-primary mb-1">${source.source.source_name}</span>
        `).join('');
    }

    function getJobTypes(jobtypesArray){
        jobTypes.value = jobtypesArray.map(job_type => `
            <span class="badge badge-primary mb-1">${job_type.job_type.job_type_name}</span>
        `).join('');
    }

    function toggleShow(){
        showMore.value = !showMore.value;
    }

    function formatPaymentTotal(total){
        if(sumOwnerPrice){
            const totalOwnerPrice = sumOwnerPrice.value + '';
            const owner_price = parseFloat(totalOwnerPrice.replace(/[$,]/g, ''));
            const job_total = owner_price + parseFloat(total);
            const formatter = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                });

            return formatter.format(job_total);
        }else{
            return '$0.0';
        }
    }

    function computePercentage(){
        if(sumOwnerPrice){
            const formatter = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                });
            const totalOwnerPrice = sumOwnerPrice.value + '';
            const owner_price = parseFloat(totalOwnerPrice.replace(/[$,]/g, ''));
            const deposit = owner_price * (proposalForm.payment_request.percentage/100);
            proposalForm.payment_request.deposit = parseFloat(deposit).toFixed(2);
            return formatter.format(deposit);
        }else{
            return '$0.0';
        }
    }

    const calculateStageTotal = (stage) => {
        const payments = proposalForm.payment_request.stage_payments[stage - 1];
        if (!payments) {
            return 0.0;
        }
        const total = payments.reduce((total, payment) => total + parseFloat(payment.stage_amount), 0.0);
        return Math.round((total + Number.EPSILON) * 100) / 100;  // rounding to 2 decimal places
    };

    const grandTotal = computed(() => {
        // Check if the stage payments structure is valid or return a default value.
        if (!proposalForm.payment_request.stage_payments) {
            return 0.0;
        }

        // Calculate the total for each stage and sum them up.
        return proposalForm.payment_request.stage_payments.reduce((total, currentStagePayments) => {
            return total + (currentStagePayments || []).reduce((stageTotal, payment) => {
            return stageTotal + parseFloat(payment.stage_amount || 0);
            }, 0.0);
        }, 0.0);
    });


    function getPaymentDue(due_type){
        const returnValue = {
            due_type: 'upon',
            days: 0
        }

        if(due_type !== 'upon'){
            returnValue.due_type = 'after';
            returnValue.days = parseInt(due_type.replace(' days after',''));
        }
        return returnValue;
    }

    function formatPaymentDue(due_type, days){
        if(due_type === 'upon'){
            return 'Upon approval';
        }else{
            return days + ' days after approval';
        }
    }

    function getPaymentType(type){
        const returnValue = {
            type: 'amount',
            percentage: 0
        }

        if(type !== 'amount'){
            returnValue.type = 'percent';
            returnValue.percentage = parseFloat(type.replace('%',''));
        }
        return returnValue;
    }

    function formatPaymentType(type, percentage){
        const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            });
        const deposit = parseFloat(proposalForm.payment_request.deposit);
        
        if(type === 'amount'){
            return formatter.format(deposit) + ' (Amount)';
        }else{
            return percentage + '% (Percentage)';
        }
    }

    function formatPaymentMethod(method){
        if(method === 'credit-ach'){
            return 'Credit Card or ACH';
        }else if(method === 'credit'){
            return 'Credit Card';
        }else if(method === 'ach'){
            return 'ACH';
        }else{
            return 'N/A';
        }
    }

    function handleSelectLead(){
        if(leads.value.length == 0){
            leads.value = [];
            searchTerm.value = '';
            fetchLeads(currentPage.value, searchTerm.value);
        }
    }

    function handleChangeLead(){
        if(itemsChange.value){
            Swal.fire({
                title: 'Are you sure?',
                text: "You have unsave changes, do you wish to proceed?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Proceed'
            }).then((result) => {
                if (result.isConfirmed) {
                    leadForm.reset();
                    form.reset();
                    proposalForm.reset();
                    show_proposal_option.value = false;
                }
            });
        }else{
            leadForm.reset();
            form.reset();
            proposalForm.reset();
            show_proposal_option.value = false;
        }
    }

    const allChecked = computed(() => proposalForm.worksheet.length === checkedItems.value.length);

    const toggleAll = () => {
        if (allChecked.value) {
            checkedItems.value = [];
        } else {
            checkedItems.value = proposalForm.worksheet.map((item, index) => `${item.proposal_item_id}_${index}`);
        }
    };

    const populateModalFromCheckedItem = () => {
        if (checkedItems.value.length === 1) {
            let [_, rowIndex] = checkedItems.value[0].split('_'); // Using destructuring to get the second split value
            rowIndex = parseInt(rowIndex); // Convert the rowIndex to a number

            let item = proposalForm.worksheet[rowIndex]; // Access the item using rowIndex
            setProposalItem(item);
        }
    };


    const deleteCheckedItems = () => {
        Swal.fire({
            title: 'Are you sure?',
            text: "You can still redo it later, as long as you don't update the proposal.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                proposalForm.worksheet = proposalForm.worksheet.filter((item, index) => 
                    !checkedItems.value.includes(`${item.proposal_item_id}_${index}`)
                );
                checkedItems.value = []; 
            }
        });
    };

    const undoChanges = () => {
        proposalForm.worksheet = initialData.value.worksheet;
    }

    function hasDataChanged() {
        const isChanged = Object.keys(proposalForm.payment_request).some(key => {
            if(key == 'stage_payments'){
                if(proposalForm.payment_request[key].length == 0){
                    return false;
                }else{
                    for (const [index, stageData] of proposalForm.payment_request[key].entries()) {
                        const item1 = initialPaymentStages.value[index];
                        const item2 = stageData;

                        if(item1.length !== item2.length){
                            return true;
                        }else{
                            let returnValue = false;
                            for (const itemData of item1) {
                                for (const initialData of item2) {
                                    if(itemData.proposal_billing_stage_id === initialData.proposal_billing_stage_id && itemData.proposal_billing_stage_id !== 0){
                                        const stage_name = itemData.stage_name !== initialData.stage_name;
                                        const stage_amount = itemData.stage_amount !== initialData.stage_amount;
                                        if(!returnValue){
                                            returnValue = (stage_name || stage_amount);
                                        }
                                    }
                                } 
                            }
                            if(returnValue){
                                return returnValue;
                            }
                        }
                    }
                }
            }
            return proposalForm.payment_request[key] != initialPaymentRequest.value[key];
        });

        if(isChanged){
            return isChanged;
        }

        return Object.keys(proposalForm).some(key => {
            if (key === 'errors') return false; // Ignore the errors property
            return proposalForm[key] !== initialData.value[key];
        });
    }

    const fetchLeads = async (pageNumber, search = '') => {
        try {
            isLoading.value = true;
            const response = await axios.get('/api/getLeadsForModal', {
                params: { 
                    page: pageNumber,
                    search: search
                },  // Pass the page as a query parameter
                headers: {
                    'Authorization': 'Bearer ' + page.props.csrf_token,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = response.data.data;
            leads.value =   data.data;
            startingEntry.value = data.from;
            endingEntry.value = data.to;
            totalEntries.value = data.total;
            totalPages.value = data.last_page || 0;
            isLoading.value = false;
        } catch (error) {
            console.error("Error fetching customers: ", error);
        }
    };

    function handleInput(e){
        proposalForm.clearErrors(e.target.name);
    }

    function handleSubmit(type){
        if(proposalForm.proposal_id === 0){
            saveProposal(type);
        }else{
            updateProposal(type);
        }
    }

    async function saveProposal(type){
        try {
            processing.value = true;
            if(type === 'send'){
                proposalForm.status = 'Sent';
            }
            const response = await axios.post('/api/saveProposal', proposalForm, {
                    headers: {
                            'Authorization': 'Bearer ' + page.props.csrf_token,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                    }
            });

            if (response.data.status === 'success') {
                let proposal_id = response.data.data.id;
                itemsChange.value = false;

                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Data has been sent successfully!',
                });

                if(type === 'stay' || type === 'send'){
                    proposalForm.proposal_id = proposal_id;

                    initialData = ref({ ...proposalForm });
                    initialWorksheet.value = proposalForm.worksheet;

                    sendProposal(proposal_id);
                    getLeadProposals();
                }else if(type === 'new'){
                    resetProposal();
                    initialData = ref({ ...proposalForm });
                    initialWorksheet.value = proposalForm.worksheet;

                    getLeadProposals();
                }else if(type === 'close'){
                    resetProposal();
                    initialData = ref({ ...proposalForm });
                    initialWorksheet.value = proposalForm.worksheet;

                    processing.value = true;
                    Inertia.get('/sales/lead-management');
                }
            } else if (response.data.status === 'error' && response.data.errors) {
                for (const [field, error] of Object.entries(response.data.errors)) {
                    proposalForm.errors[field] = error[0];
                }
            }
            
            processing.value = false;
        } catch (error) {
            processing.value = false;
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: `There was a problem when saving the data! .${ error }`,
            });
        }
    }

    async function updateProposal(type){
        try {
            processing.value = true;
            if(type === 'send'){
                proposalForm.status = 'Sent';
            }
            const response = await axios.post(`/api/updateProposal/${proposalForm.proposal_id}`, proposalForm, {
                headers: {
                    'Authorization': 'Bearer ' + page.props.csrf_token,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.data.status === 'success') {
                let proposal_id = response.data.data.id;
                itemsChange.value = false;

                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Data has been sent successfully!',
                });
                
                if(type === 'stay' || type === 'send'){
                    proposalForm.proposal_id = proposal_id;

                    initialData = ref({ ...proposalForm });
                    initialWorksheet.value = proposalForm.worksheet;
                    sendProposal(proposal_id);
                    getLeadProposals();
                }else if(type === 'new'){
                    resetProposal();
                    initialData = ref({ ...proposalForm });
                    initialWorksheet.value = proposalForm.worksheet;

                    getLeadProposals();
                }else if(type === 'close'){
                    resetProposal();
                    initialData = ref({ ...proposalForm });
                    initialWorksheet.value = proposalForm.worksheet;

                    processing.value = true;
                    Inertia.get('/sales/lead-management');
                }
            } else if (response.data.status === 'error' && response.data.errors) {
                for (const [field, error] of Object.entries(response.data.errors)) {
                    proposalForm.errors[field] = error[0];
                }
            }
            
            processing.value = false;
        } catch (error) {
            processing.value = false;
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: `There was a problem when saving the data! .${ error }`,
            });
        }
    }

    async function sendProposal(proposal_id){
        try {
            proposal_option_loading.value = true;
            proposal_options.value = [];
            const response = await axios.post(`/api/send`, {
                data: {
                    SEND_BY: page.props.user_display_name,
                    DISPLAY_NAME: page.props.lead.lead_customer.display_name,
                    CODE: btoa(proposal_id),
                    COMPANY_NAME: page.props.company_name
                },
                recipient: ['louiefuentes.dev@gmail.com', 'dev@buildovate.com'],
                cc: ['joe@buildovate.com'],
                subject: emailSubject.value,
                view: 'emails.send-proposal'
            }, {
                headers: {
                    'Authorization': 'Bearer ' + page.props.csrf_token,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

        } catch (error) {
            console.error(error);
        }
    }

    async function getLeadProposals(){
        try {
            proposal_option_loading.value = true;
            proposal_options.value = [];
            const response = await axios.get(`/api/getLeadProposals/${leadForm.lead_id}`, {}, {
                headers: {
                    'Authorization': 'Bearer ' + page.props.csrf_token,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            proposal_option_loading.value = false;
            if (response.data.status === 'success') {
                let lead_proposals = response.data.data;

                if(lead_proposals.length != 0){
                    proposal_options.value = lead_proposals;
                }else{
                    proposal_options.value = [];
                }

                if(proposalForm.proposal_id === 0){
                    selected_proposal.value = null;
                }else{
                    const matchingProposal = proposal_options.find(proposalObj =>
                        proposalObj.proposal_id === proposalForm.proposal_id
                    );

                    // Set selected_proposal to the found object, or null if not found
                    selected_proposal.value = matchingProposal ? matchingProposal.proposal : null;
                }

            } else if (response.data.status === 'error' && response.data.errors) {
                for (const [field, error] of Object.entries(response.data.errors)) {
                    proposalForm.errors[field] = error[0];
                }
            }
        } catch (error) {
            proposal_option_loading.value = false;
        }
    }

    function formatPhoneNumber(number) {
        if(number){
            const cleaned = ('' + number).replace(/\D/g, '');
            const match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
            if (match) {
                    return '(' + match[1] + ') ' + match[2] + '-' + match[3];
            }
            return number;
        }else{
            return 'N/A';
        }
   }

   function formatCurrency(amount) {
        if(amount){
            const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            });
            return formatter.format(parseFloat(amount));
        }else{
            return '$0.0';
        }
   }

    async function generatePDF() {
        generatingPDF.value = true;
        try {
            const opt = {
                margin: 10,
                filename: 'myfile.pdf',
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            
            try {
                const response = await axios.get('/api/proposal-content', {
                    params: {
                        DISPLAY_NAME: page.props.lead.lead_customer.display_name,
                        CUSTOMER_PHONE: page.props.lead.lead_customer.phone,
                        JOBSITE_ADDRESS: page.props.lead.street_address,
                        JOBSITE_CITY: page.props.lead.city,
                        JOBSITE_STATE: page.props.lead.state,
                        JOBSITE_ZIPCODE: page.props.lead.zipcode,
                        COMPANY_LICENSE: page.props.company_license_number,
                        COMPANY_ADDRESS: page.props.company_address,
                        COMPANY_CITY: page.props.company_city,
                        COMPANY_STATE: page.props.company_state,
                        COMPANY_ZIPCODE: page.props.company_zipcode
                    },
                    headers: {
                        'Authorization': 'Bearer ' + page.props.csrf_token,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                        }
                });
                await html2pdf().set(opt).from(response.data).toPdf().get('pdf').then((pdf) => {
                    generatingPDF.value = false;
                    const pdfOutput = pdf.output('blob');
                    const url = window.URL.createObjectURL(pdfOutput) + '#navpanes=0';
                    pdfIframe.value.src = url;

                    nextTick(() => {
                        if (select2Recepient.value) {
                            select2Recepient.value.initialSelect2(); 
                        }
                        if (select2Cc.value) {
                            select2Cc.value.initialSelect2(); 
                        }
                        if (select2Numbers.value) {
                            select2Numbers.value.initialSelect2(); 
                        }
                    });
                });
            } catch (error) {
                console.error('Failed to fetch proposal:', error);
            }
        } catch (error) {
            generatingPDF.value = false;
            console.error('Error generating PDF:', error);
        }
    }

    function setMarkupColumn(item){
        if(item){
            const item_m_type = item.unit_mark_up_type;
            const item_m_amount = item.unit_mark_up;
            const item_unit = item.unit;
            let markUpReturn = '';

            const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            });

            if(item_m_type === '%'){
                return formatter.format(item_m_amount) + '%';
            }else if(item_m_type === '$/'){
                return formatter.format(item_m_amount) + '/' + item_unit;
            }else if(item_m_type === '$'){
                return formatter.format(item_m_amount);
            }else if(item_m_type === '--'){
                return '--'
            }

            return markUpReturn;
        }else{
            return 'N/A';
        }
    }

    function setOwnerPrice(item){
        if(item){
            const builder_cost = parseFloat(item.unit_cost * item.unit_quantity);
            const item_m_type = item.unit_mark_up_type;
            const item_m_amount = parseFloat(item.unit_mark_up);
            const quantity = item.unit_quantity;
            let markUpReturn = '';

            const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            });

            if(item_m_type === '%'){
                return formatter.format(builder_cost + ((item_m_amount/100) * builder_cost));
            }else if(item_m_type === '$/'){
                return formatter.format(builder_cost + (item_m_amount * quantity));
            }else if(item_m_type === '$'){
                return formatter.format(builder_cost + item_m_amount);
            }else if(item_m_type === '--'){
                return formatter.format(builder_cost);
            }

            return markUpReturn;
        }else{
            return '$0.0';
        }
    }

    
    function getMarkup(unit_mark_up_type, unit_mark_up, unit_quantity, builder_cost){
        let markUpReturn = 0.0;

        if(unit_mark_up_type === '%'){
            return ((unit_mark_up/100) * builder_cost);
        }else if(unit_mark_up_type === '$/'){
            return (unit_mark_up * unit_quantity);
        }else if(unit_mark_up_type === '$'){
            return unit_mark_up;
        }else if(unit_mark_up_type === '--'){
            return 0.0;
        }

        return markUpReturn;
    }
    
    const getProposalItems = async () => {
        try {
            const response = await axios.get(`/api/getProposalItems/${proposalForm.proposal_id}`, {}, {
                headers: {
                    'Authorization': 'Bearer ' + page.props.csrf_token,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = response.data;
            const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            });

            proposalForm.worksheet = data.data.map(item => ({
                ...item,   
                unit_cost: formatter.format(item.unit_cost),
                unit_mark_up: setMarkupColumn(item),
                builder_cost: formatter.format(item.unit_cost * item.unit_quantity),
                discount: formatter.format(item.discount),
                owner_price: setOwnerPrice(item),
                labor: (item.labor === 0) ? 'Labor' : 'Labor + Material'
            }));

            // Compute the sums
            sumBuilderCost.value = proposalForm.worksheet.reduce((acc, item) => acc + parseFloat(item.builder_cost.replace(/[$,]/g, '')), 0);
            sumOwnerPrice.value = proposalForm.worksheet.reduce((acc, item) => acc + parseFloat(item.owner_price.replace(/[$,]/g, '')), 0);
            totalMarkup.value = data.data.reduce((acc, item) => acc + parseFloat(getMarkup(item.unit_mark_up_type, item.unit_mark_up, item.unit_quantity, (item.unit_cost * item.unit_quantity))), 0);
            
            // Format the sums back to currency format for display
            estimatedProfit.value = formatter.format(sumOwnerPrice.value - sumBuilderCost.value);
            totalMargin.value = formatter.format(((sumOwnerPrice.value - sumBuilderCost.value)/sumOwnerPrice.value) * 100) + '%';
            sumBuilderCost.value = formatter.format(sumBuilderCost.value);
            sumOwnerPrice.value = formatter.format(sumOwnerPrice.value);
            totalMarkup.value = formatter.format(totalMarkup.value);

            initialWorksheet.value = proposalForm.worksheet;
        } catch (error) {
            console.error("Error fetching proposal items: ", error);
        }
    };

    const getProposalPaymentRequest = async () => {
        try {
            const response = await axios.get(`/api/getProposalPaymentRequest/${proposalForm.proposal_id}`, {}, {
                headers: {
                    'Authorization': 'Bearer ' + page.props.csrf_token,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = response.data;

            if(data.status === 'success'){
                const billingData = data.data;
                if(billingData){
                    const deposit_type = getPaymentType(billingData.deposit_type);
                    const payment_due = getPaymentDue(billingData.payment_due);
                    proposalForm.payment_request = {
                        proposal_billing_id: billingData.proposal_billing_id,
                        deposit: parseFloat(billingData.deposit).toFixed(2),
                        deposit_type: deposit_type.type,
                        percentage: parseFloat(deposit_type.percentage),
                        stages: billingData.stages,
                        payment_due: payment_due.due_type,
                        payment_due_day: payment_due.days,
                        payment_method: billingData.payment_method,
                        stage_payments: proposalForm.payment_request.stage_payments
                    }

                    proposalForm.payment_request.stage_payments = [];
                    initialPaymentStages.value = [];
                    for (let i = 0; i < billingData.stages; i++) {
                        proposalForm.payment_request.stage_payments.push([]);
                        initialPaymentStages.value.push([]);
                    }

                    billingData.stages_detail.forEach(stage => {
                        const index = stage.stage_number - 1;
                        if (index >= 0 && index < proposalForm.payment_request.stage_payments.length) {
                            const newForm = useForm({
                                proposal_billing_stage_id: stage.proposal_billing_stage_id,
                                proposal_billing_id: stage.proposal_billing_id,
                                stage_name: stage.stage_name,
                                stage_number: stage.stage_number,
                                stage_amount: stage.stage_amount,
                                update_stage: stage
                            });
                            proposalForm.payment_request.stage_payments[index].push(newForm);
                            initialPaymentStages.value[index].push(newForm);
                        }
                    });
                    

                    togglePaymentAmountValue(deposit_type.type);
                }
            }

            initialData = ref({ ...proposalForm });
            initialPaymentRequest = ref({ ...proposalForm.payment_request});

            fetchingData.value = false; //make sure to add this before the end of fetching DATA
        } catch (error) {
            console.error("Error fetching  payment request: ", error);
        }
    }; 

    function handleDeleteStage(stage, index){
        Swal.fire({
            title: 'Are you sure?',
            text: "Once removed, can't be reverted, do you wish proceed?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Proceed'
        }).then((result) => {
            if (result.isConfirmed) {
                proposalForm.payment_request.stage_payments[stage - 1].splice(index);
            }
        });
    }

    function handleUpdateStage(element, index, stage){
        proposalStagePaymentForm.update_index = index;
        proposalStagePaymentForm.update_stage = stage;
        proposalStagePaymentForm.proposal_billing_stage_id = element.proposal_billing_stage_id;
        proposalStagePaymentForm.proposal_billing_id = element.proposal_billing_id;
        proposalStagePaymentForm.stage_name = element.stage_name;
        proposalStagePaymentForm.stage_amount = element.stage_amount;
    }

    function handleStagePaymentSubmit(update_stage, update_index){
        if(update_index != -1){
            const newStage = proposalStagePaymentForm;
            proposalForm.payment_request.stage_payments[update_stage - 1][update_index] = {
                proposal_billing_stage_id: newStage.proposal_billing_stage_id,
                proposal_billing_id: newStage.proposal_billing_id,
                stage_name: newStage.stage_name,
                stage_amount: newStage.stage_amount
            };
        }else{
            const newStage = proposalStagePaymentForm;
            proposalForm.payment_request.stage_payments[proposalForm.payment_request.stages - 1].push({
                proposal_billing_stage_id: newStage.proposal_billing_stage_id,
                proposal_billing_id: newStage.proposal_billing_id,
                stage_name: newStage.stage_name,
                stage_amount: newStage.stage_amount
            });
        }
        
        document.querySelector('#addStagePayment .btn-close').click();
    }

    function handleAddStagePayment(){
        proposalStagePaymentForm.update_index = -1;
        proposalStagePaymentForm.update_stage = 0;
        proposalStagePaymentForm.proposal_billing_stage_id = 0;
        proposalStagePaymentForm.stage_name = '';
        proposalStagePaymentForm.stage_amount = 0.0;
    }

    function handleAddItem(){
        costItemType.value = 'newValue';
        var modal = document.querySelector('#costItemModal');
        var bootstrapModal = new bootstrap.Modal(modal, {backdrop: 'static', keyboard: false});
        bootstrapModal.show();
    }

    function handleCatalogClicked(){
        costItemType.value = 'default';
        var modal = document.querySelector('#costItemListModal');
        var bootstrapModal = new bootstrap.Modal(modal, {backdrop: 'static', keyboard: false});
        bootstrapModal.show();
    }

    function handleEstimateClicked(){
        Swal.fire({
            icon: 'info',
            title: 'Hold on...!',
            text: 'Import from estimates coming soon!',
        });
    }

    const resetSelectedCostItem = () => {
        selectedItem.value = true;
    }

    const handleChangeCostItem = (value) => {
        reloadCostItems.value = true;
    }

    function handleSelectedCostItem(value){
        selectedItem.value = value;
    }

    function handleSelectedCostItems(value){
        processNewWorksheetItem(value);
    }

    function handleNewCostItem(value){
        processNewWorksheetItem(value);
    }

    function processNewWorksheetItem(value){
        if (Array.isArray(value)) {
            value.forEach((element) => {
                overallCalculation(element);
            });
        } else {
            overallCalculation(value);
        }
    }

    function transformCostItem(item){
        const newItem = { ...item};

        const formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
        });

        return {
            ...newItem,   
            proposal_item_id: newItem.proposal_item_id ? newItem.proposal_item_id : 0,
            unit_cost: formatter.format(newItem.unit_cost),
            unit_mark_up: setMarkupColumn(newItem),
            builder_cost: formatter.format(newItem.unit_cost * newItem.unit_quantity),
            discount: formatter.format(newItem.discount),
            owner_price: setOwnerPrice(newItem),
            labor: (newItem.labor === 0) ? 'Labor' : 'Labor + Material',
        }
    }

    function overallCalculation(value){
        const formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
        });
            const newItem = value;
            const transformedNewItem = transformCostItem(value);

            if (checkedItems.value.length === 1) {
                let [_, rowIndex] = checkedItems.value[0].split('_');
                rowIndex = parseInt(rowIndex);

                proposalForm.worksheet.splice(rowIndex, 1, transformedNewItem);
            }else{
                proposalForm.worksheet = [...proposalForm.worksheet, transformedNewItem];
            }

            let sumBC = parseFloat(0.0);
            if(sumBuilderCost.value != 0){
                sumBC = parseFloat(sumBuilderCost.value.replace(/[$,]/g, ''));
            }
            let sumOP = parseFloat(0.0);
            if(sumOwnerPrice.value != 0){
                sumOP = parseFloat(sumOwnerPrice.value.replace(/[$,]/g, ''));
            }

            sumBuilderCost.value = sumBC + parseFloat(transformedNewItem.builder_cost.replace(/[$,]/g, ''));
            sumOwnerPrice.value = sumOP + parseFloat(transformedNewItem.owner_price.replace(/[$,]/g, ''));
            totalMarkup.value += parseFloat(getMarkup(newItem.unit_mark_up_type, newItem.unit_mark_up, newItem.unit_quantity, (newItem.unit_cost * newItem.unit_quantity)));

            estimatedProfit.value = formatter.format(sumOwnerPrice.value - sumBuilderCost.value);
            totalMargin.value = formatter.format(((sumOwnerPrice.value - sumBuilderCost.value) / sumOwnerPrice.value) * 100) + '%';
            sumBuilderCost.value = formatter.format(sumBuilderCost.value);
            sumOwnerPrice.value = formatter.format(sumOwnerPrice.value);
            totalMarkup.value = formatter.format(totalMarkup.value);
    }

    const handleChooseMessageTemplate = () => {
        Swal.fire({
            icon: 'info',
            title: 'Hold on...!',
            text: 'Choose SMS template coming soon!',
        });
    }

    const fetchSalesPersons = async () => {
        try {
            userLoading.value = true;
            const response = await axios.get('/api/userContacts', {
                headers: {
                    'Authorization': 'Bearer ' + page.props.csrf_token,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = response.data;

            userData.value = Object.values(data.data).map(userDetails => {
                return {
                    text: userDetails.display_name,
                    id: userDetails.user_id ? userDetails.user_id : userDetails.cust_id,
                    email: userDetails.email,
                    phone: userDetails.phone,
                    type: userDetails.user_id ? 'crew' : 'customer'
                };
            })

            userLoading.value = false;
        } catch (error) {
            console.error("Error fetching customers: ", error);
        }
    };
           
    watch(searchTerm, (newValue) => {
        fetchLeads(currentPage.value, newValue);
    });

    watch(selected_proposal, (newValue) => {
        if(itemsChange.value){
            Swal.fire({
                title: 'Are you sure?',
                text: "You have unsave changes, do you wish to proceed?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Proceed'
            }).then((result) => {
                if (result.isConfirmed) {
                    populateProposalData(newValue);
                }
            });
        }else{
            populateProposalData(newValue);
        }
    }, { deep: true });

    watch(proposalForm, (_) => {
        if(proposalForm.proposal_id != 0 && !fetchingData.value){
            itemsChange.value = hasDataChanged();
        }
    }, {deep: true});

   onMounted(async () => {
        if(leadData.value){
            populateLeadFormWithLeadData(leadData.value);
        }

        if(proposalData.value){
            populateProposalData(proposalData.value);
        }
        fetchSalesPersons();
        document.addEventListener('click', handleDocumentClick);
   });

   onBeforeUnmount(() => {
        document.removeEventListener('click', handleDocumentClick);
    });

    defineProps(['pageTitle', 'errors', 'appName', 'csrf_token', 'style', 'flash', 'lead', 'auth']);

</script>
<style scoped>
    .overflow-handler{
        overflow: hidden;
    }
    .table-responsive {
        overflow: auto;
        width: 100%;
    }

    #proposal-list  {
        table-layout: fixed;
    }

    #proposal-list tbody tr:hover {
        background-color: #e6edef; /* light gray background on hover */
    }

    #proposal-list tbody tr:hover td,
    #proposal-list tbody tr:hover td.sticky,
    #proposal-list tbody tr:hover td.sticky-second-last {
        background-color: #e6edef; /* ensures the hover background color is consistent across all cells */
    }

    #proposal-list tbody tr td:hover {
        border: 2px solid #24695c !important;
    }

    #proposal-list thead {
        background-color: #e6edef;
    }

    #proposal-list tbody tr td {
        position: relative;
    }

    #proposal-list thead th {
        position: sticky;
        top: 0;
        background-color: #e6edef;
        z-index: 5;
        box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.1);
    }

    .table-responsive::-webkit-scrollbar {
        width: 5px;  /* Width of vertical scrollbar */
        height: 5px;  /* Height of horizontal scrollbar */
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background-color: #888;
        border-radius: 4px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background-color: #555;
    }

    .table-responsive::-webkit-scrollbar-track {
        background-color: #f1f1f1;
        border-radius: 4px;
    }
    .progress-bar-animated {
        animation: progress-bar-stripes 0.5s linear infinite !important;
    }
    .progress-bar-striped.bg-secondary {
        background-size: 100% 100%;
    }

    @keyframes swing {
        0%, 20% {
            transform: rotate(0deg);
        }
        25% {
            transform: rotate(-8deg);
        }
        30% {
            transform: rotate(8deg);
        }
        35% {
            transform: rotate(-4deg);
        }
        40% {
            transform: rotate(4deg);
        }
        45% {
            transform: rotate(-2deg);
        }
        50% {
            transform: rotate(2deg);
        }
        55%, 100% {
            transform: rotate(0deg);
        }
    }

    .swing {
        display: inline-block;
        transform-origin: top center;
        animation: swing 1.5s ease-in-out infinite;
    }
    .wrap-content {
        flex-wrap: wrap;
    }

    :deep(.v-chip--variant-outlined),
    :deep(.v-chip--variant-plain),
    :deep(.v-chip--variant-text),
    :deep(.v-chip--variant-tonal) {
        background-color: #24695c !important; 
        color: #fff !important;
    }

    :deep(.v-input__details){
        display: none !important;
    }

    /* These are generic styles for the table. */
    #proposal-list {
        width: 100%;
        position: relative;
        border-collapse: collapse;
    }

    #proposal-list th, .table td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #proposal-list th.sticky{
        position: sticky;
        right: 0; /* Adjust this value if there are other sticky columns */
        z-index:6; /* Make sure sticky columns stay on top */
        background-color: #e6edef; /* To prevent see-through when scrolling */
    }

    #proposal-list td.sticky {
        position: sticky;
        right: 0; /* Adjust this value if there are other sticky columns */
        z-index:6; /* Make sure sticky columns stay on top */
        background-color: white; /* To prevent see-through when scrolling */
        box-sizing: border-box;
    }    /* If you have multiple sticky columns, you may need to adjust right positioning accordingly. */
    #proposal-list th.sticky-second-last {
        position: sticky;
        right: 150px; /* Replace [width_of_last_column] with the width of your last column, e.g., 100px */
        z-index: 6;
        background-color: #e6edef;
        border-left: 3px solid #ddd;
    }

    #proposal-list td.left-sticky-title{
        position: sticky;
        left: 0px;
        z-index: 6;
        background-color: white;
        box-sizing: border-box;
        border-right: 3px solid #ddd;
    }

    #proposal-list td.left-sticky-title::before, th.left-sticky-title::before {
        content: ''; /* necessary for the pseudo-element to work */
        position: absolute;
        top: 0;
        bottom: 0;
        right: -2px; /* push it to the left edge of the cell */
        width: 3px;
        background-color: #ddd; /* adjust color as needed */
        z-index: 7; /* make sure it stays on top */
    }

    #proposal-list th.left-sticky-title{
        position: sticky;
        left: 0px;
        z-index: 6;
        background-color: #e6edef;
        box-sizing: border-box;
        border-right: 3px solid #ddd;
    }

    #proposal-list td.sticky-second-last{
        position: sticky;
        right: 150px; /* Replace [width_of_last_column] with the width of your last column, e.g., 100px */
        z-index: 6;
        background-color: white;
        box-sizing: border-box;
        border-left: 3px solid #ddd;
    }

    #proposal-list td.sticky-total{
        position: sticky;
        right: 300px; /* Replace [width_of_last_column] with the width of your last column, e.g., 100px */
        z-index: 6;
        background-color: #e6edef;
    }

    #proposal-list td.sticky-second-last::before, th.sticky-second-last::before {
        content: ''; /* necessary for the pseudo-element to work */
        position: absolute;
        top: 0;
        bottom: 0;
        left: -2px; /* push it to the left edge of the cell */
        width: 3px;
        background-color: #ddd; /* adjust color as needed */
        z-index: 7; /* make sure it stays on top */
    }

    .import-hover-effect:hover{
        background-color: #24695C;
        border-radius: 10px;
        color: white !important;
    }

    .import-popover{
        position: absolute;
        z-index: 10;
        padding: 15px;
        top: -140px;
        left: calc(50% - 150px);
        width: 290px;
        background-color: white;
        border: solid 2px #24695c;
        border-radius: 10px;
        box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0 10px 10px rgba(0, 0, 0, 0.06);
    }

    
    .import-popover::before{
        content: '';
        position: absolute;
        bottom: -10px; /* Position it at the top */
        left: calc(50% - 5px); /* Center it horizontally. The arrow is 10px wide, so we subtract half of that */
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 10px solid #24695c; /* This forms the upward pointing arrow */
    }

    .breakdown-popover{
        position: absolute;
        z-index: 10;
        padding: 15px;
        top: 30px;
        left: calc(50% - 175px);
        width: 350px;
        background-color: white;
        border: solid 2px #24695c;
        border-radius: 10px;
        box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0 10px 10px rgba(0, 0, 0, 0.06);
    }

    .breakdown-popover::before {
        content: '';
        position: absolute;
        top: -10px; /* Position it at the top */
        left: calc(50% - 5px); /* Center it horizontally. The arrow is 10px wide, so we subtract half of that */
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 10px solid #24695c; /* This forms the upward pointing arrow */
    }

    .sendOptions-popover{
        position: absolute;
        z-index: 10;
        padding: 15px;
        top: calc(50% - 175px);
        right: 0;
        width: 250px;
        background-color: white;
        border: solid 2px #24695c;
        border-radius: 10px;
        box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1), 0 10px 10px rgba(0, 0, 0, 0.06);
    }

    .sendOptions-popover::before {
        content: '';
        position: absolute;
        bottom: -10px; /* Position it at the top */
        left: calc(80% - 5px); /* Center it horizontally. The arrow is 10px wide, so we subtract half of that */
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 10px solid #24695c; /* This forms the upward pointing arrow */
    }

    .loader-17 {
        background-color: var(--main-bg-color, #24695c); /* Default color is #24695c if --main-bg-color is not set */
        --main-bg-color: #24695c;
    }

    .loader-17::before,
    .loader-17::after {
        background-color: var(--main-bg-color); /* Using the set CSS variable */
        /* ... Other styles for before and after pseudo-elements ... */
    }

    .pill-input-group {
        border: 1px #1b4c43 solid !important;
        height: 35px !important;
        width: 260px;
    }

    .input-group-text {
        height: 33px !important;
        background-color: #1b4c43;
        color: white;
    }

    .decrement-button,
    .increment-button {
        cursor: pointer;
    }

    .stage-input {
        height: 33px !important;
    }

    .stage-input-label {
        height: 33px !important;
        width: 150px !important;
    }

    .custom-border{
        border-color: #d5d7d6 !important;
        border-style: solid!important;
        border-width: thin!important;
    }
    .payment-amount-style{
        width: 20%; 
        background-color: #f5f7fb; 
        position: absolute; 
        right: 0; 
        top: 3px; 
        bottom: 0; 
        display: flex; 
        align-items: center; 
        justify-content: center;
    }

    .btn-outline-customize:hover{
        background-color: #24695C !important;
        color: white !important;
    }    
    
    .btn-outline-customize{
        border-color: #757575 !important;
        color: #757575 !important;
    }
    
    .btn-outline-light:hover{
            background-color: #24695C !important;
            color: white !important;
    }    
        
    .btn-outline-light{
        border-color: #757575 !important;
        color: #757575 !important;
        height: 37.15px !important;
    }

    .btn-outline-primary{
        height: 37.15px !important;
    }

</style>
