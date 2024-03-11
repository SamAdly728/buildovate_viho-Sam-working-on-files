<script setup>
import { ref, watch, onMounted } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { Inertia } from "@inertiajs/inertia";
import VueGoogleAutocomplete from "vue-google-autocomplete";
import { processBecomeAPro } from "@/api/api";
import { toast } from "vue3-toastify";
const page = usePage();

const props = defineProps(["user", "pro_user"]);

const form = useForm({
  business_name: "",
  firstname: "",
  lastname: "",
  business_email: "",
  occupation: "",
  cell_phone: "",
  business_website: "",
  street: "",
  city: "",
  state: "",
  zipcode: "",
  specialties: "",
  is_licensed: "0",
  license_number: "",
  _token: page.props.csrf_token
});

const showAnswerInput = ref(false);
const is_licensed = ref(false);
const pro_id = ref(null);

const onCustomerAddressChange = (value) => {
  form.street = value.target.value;
};

/* Auto populate address*/
const getAddressData = async (addressData, placeResultData, id) => {
  const placeAddress = placeResultData.address_components;

  let streetAddress = "";

  for (const component of placeAddress) {
    const componentType = component.types[0];
    // console.log("componentType", componentType);
    switch (componentType) {
      case "street_number":
        streetAddress = component.long_name;
        break;
      case "route":
        streetAddress += " " + component.long_name;
        break;
      case "postal_code":
        form.zipcode = component.long_name;
        break;
      case "administrative_area_level_1":
        form.state = component.long_name;
        break;
      case "administrative_area_level_2":
        form.state = component.long_name;
        break;
      case "neighborhood":
        form.city = component.long_name;
        break;
    }
  }
  if (streetAddress) {
    form.street = streetAddress;
  }
};
const handleSubmit = () => {
  var checkboxes = document.querySelectorAll(".single-checkbox:checked");
  // Filter out checked checkboxes
  var checkedCheckboxes = Array.from(checkboxes).filter(function (checkbox) {
    return checkbox.checked;
  });

  // Display the values of checked checkboxes
  var values = checkedCheckboxes.map(function (checkbox) {
    return checkbox.value;
  });

  // console.log("Checked Checkboxes: " + values.join(", "));
  form.specialties = values.join(", ");
  form.specialties_array = values;
  form.is_licensed = is_licensed.value ? 1 : 0;
  let payload = JSON.parse(JSON.stringify(form));
  processBecomeAPro(payload)
    .then((response) => {
      // console.log(response);
      if (response && response.status == "success") {
        toast.success(`Successfully added`);
      } else {
        toast.error(`Error: Something went wrong. Please try again`);
      }
    })
    .catch((error) => {
      console.log(error);
      toast.error(`Error: Something went wrong. Please try again`);
    });
};

onMounted(() => {
  if (props.pro_user) {
    pro_id.value = props.pro_user.pro_id;
    form.business_name = props.pro_user.firstname;
    form.firstname = props.pro_user.firstname;
    form.lastname = props.pro_user.lastname;
    form.business_email = props.pro_user.business_email;
    form.occupation = props.pro_user.occupation;
    form.cell_phone = props.pro_user.cell_phone;
    form.business_website = props.pro_user.business_website;
    form.street = props.pro_user.street;
    form.city = props.pro_user.city;
    form.state = props.pro_user.state;
    form.zipcode = props.pro_user.zipcode;
    form.specialties = props.pro_user.specialties;
    form.is_licensed = props.pro_user.is_licensed;
    form.license_number = props.pro_user.license_number;
    // console.log(props.pro_user.is_licensed);
    is_licensed.value = props.pro_user.is_licensed == 1 ? true : false;

    $('#add_street_pro_user').val(form.street);
  }
  if (!props.pro_user) {
    form.business_name = props.user.display_name;
    form.firstname = props.user.first_name;
    form.lastname = props.user.last_name;
    form.business_email = props.user.email;
    form.cell_phone = props.user.phone;
  }
});
watch([is_licensed], () => {
  // console.log("is_licensed", is_licensed.value);
  showAnswerInput.value = is_licensed.value ? true : false;
});
</script>
<template>
  <form class="card" method="post" @submit.prevent="handleSubmit">
    <div class="p-3">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <div class="card rounded shadow-sm">
                <div class="card-body">
                  <div class="mb-3">
                    <label class="form-label" for="business_name"
                      >Business Name</label
                    >
                    <input
                      class="form-control"
                      id="business_name"
                      type="text"
                      placeholder="Business name..."
                      v-model="form.business_name"
                      required
                    />
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="firstname">First Name</label>
                    <input
                      class="form-control"
                      id="firstname"
                      type="text"
                      placeholder="First name..."
                      v-model="form.firstname"
                      required
                    />
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="lastname">Last Name</label>
                    <input
                      class="form-control"
                      id="lastname"
                      type="text"
                      placeholder="Last name..."
                      v-model="form.lastname"
                      required
                    />
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="exampleFormControlInput1"
                      >Occupation</label
                    >
                    <input
                      class="form-control"
                      id="exampleFormControlInput1"
                      type="text"
                      placeholder="Occupation..."
                      v-model="form.occupation"
                      required
                    />
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="business_email">Email</label>
                    <input
                      class="form-control"
                      id="business_email"
                      type="email"
                      placeholder="Email..."
                      v-model="form.business_email"
                      required
                    />
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="cell_phone"
                      >Mobile Phone</label
                    >
                    <input
                      class="form-control"
                      id="cell_phone"
                      type="number"
                      placeholder="Mobile number..."
                      v-model="form.cell_phone"
                      required
                    />
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="street">Address</label>
                    <!-- <input
                      class="form-control"
                      id="exampleFormControlInput1"
                      type="street"
                      placeholder="Address..."
                      v-model="form.street"
                      required
                    /> -->
                    <vue-google-autocomplete
                      id="add_street_pro_user"
                      name="add_street_pro_user"
                      classname="form-control border-success"
                      placeholder="Home Address"
                      @input="onCustomerAddressChange"
                      required
                      v-on:placechanged="getAddressData"
                      :country="['us']"
                      :type="['address']"
                    >
                    </vue-google-autocomplete>
                  </div>

                  <div class="mb-3">
                    <div class="row">
                      <div class="col-sm-6 col-md-4">
                        <div class="mb-3">
                          <label class="form-label f-w-600">City</label>
                          <input
                            class="form-control border-success"
                            type="text"
                            placeholder="City"
                            v-model="form.city"
                            name="city"
                            required
                          />
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-3">
                        <div class="mb-3">
                          <label class="form-label f-w-600">Postal Code</label>
                          <input
                            class="form-control border-success"
                            type="number"
                            placeholder="ZIP Code"
                            v-model="form.zipcode"
                            name="zipcode"
                            required
                          />
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="mb-3">
                          <label class="form-label f-w-600">State</label>
                          <input
                            class="form-control border-success"
                            type="text"
                            placeholder="State"
                            v-model="form.state"
                            name="state"
                            required
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="business_website"
                      >Business Website</label
                    >
                    <input
                      class="form-control"
                      id="business_website"
                      type="text"
                      placeholder="Business website..."
                      v-model="form.business_website"
                      required
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card rounded shadow-sm">
                <div class="card-body">
                  <h6 class="form-label">Are you Licensed?</h6>
                  <div class="ml-2 mb-4">
                    <div
                      class="form-group m-t-15 m-checkbox-inline mb-0 custom-radio-ml"
                    >
                      <div class="radio radio-primary">
                        <input
                          id="licensed-yes"
                          type="radio"
                          name="yes-or-no"
                          :value="true"
                          v-model="is_licensed"
                        />
                        <label class="mb-0 form-label" for="licensed-yes"
                          >Yes</label
                        >
                      </div>
                      <div class="radio radio-primary">
                        <input
                          id="licensed-no"
                          type="radio"
                          name="yes-or-no"
                          :value="false"
                          v-model="is_licensed"
                        />
                        <label class="mb-0 form-label" for="licensed-no"
                          >No</label
                        >
                      </div>
                    </div>
                  </div>
                  <transition>
                    <div class="mb-3" v-show="showAnswerInput">
                      <label class="form-label" for="license-number"
                        ><span class="h5 form-label">If Yes</span>: What is your
                        License number?</label
                      >
                      <input
                        class="form-control"
                        id="license-number"
                        type="text"
                        placeholder="License number..."
                        v-model="form.license_number"
                      />
                    </div>
                  </transition>
                  <div>
                    <div class="filters">
                      <div v-for="(val, i) in filters" :key="i">
                        <div v-for="(v, e) in val" :key="e">
                          <div v-for="(k, r) in v" :key="r">
                            <!--                          <div class="d-flex justify-content-start items-center">-->
                            <button
                              @click="
                                toggleFilterMain(e.replace(/[\s-&]+/g, '-'))
                              "
                              class="btn btn-link pt-0 pb-0 ps-0 toggle-button-main"
                              role="button"
                              type="button"
                            >
                              <p
                                :class="
                                  'text-success toggle-button-text rounded ' +
                                  e.replace(/[\s-&]+/g, '-')
                                "
                              >
                                {{ e }}
                              </p>
                            </button>
                            <!--                          </div>-->
                            <small
                              ><i
                                v-if="
                                  isActiveMain != e.replace(/[\s-&,]+/g, '-')
                                "
                                class="icofont icofont-rounded-left-up text-success float-end"
                              ></i
                            ></small>
                            <small
                              ><i
                                v-if="
                                  isActiveMain == e.replace(/[\s-&,]+/g, '-')
                                "
                                class="icofont icofont-rounded-left-down text-success float-end"
                              ></i
                            ></small>
                            <transition-group>
                              <div
                                v-for="(c, l) in k"
                                v-show="
                                  isActiveMain === e.replace(/[\s-&]+/g, '-')
                                "
                                :key="l"
                              >
                                <div
                                  class="ml-5"
                                  :id="e.replace(/[\s-&]+/g, '-')"
                                  :aria-labelledby="e"
                                  data-parent=""
                                >
                                  <!--                                <div class="d-flex justify-content-start  items-center">-->
                                  <button
                                    @click="
                                      toggleFilterSub(
                                        l.replace(/[\s-&,]+/g, '-')
                                      )
                                    "
                                    v-if="l != 'tempKeyName'"
                                    class="btn btn-link pt-1 pb-1 ps-0 mb-0 toggle-button"
                                    type="button"
                                  >
                                    <small
                                      class="text-success toggle-button-text rounded"
                                      >{{ l }}</small
                                    >
                                  </button>
                                  <small
                                    ><i
                                      v-if="
                                        isActiveSub !=
                                          l.replace(/[\s-&,]+/g, '-') &&
                                        l != 'tempKeyName'
                                      "
                                      class="icofont icofont-rounded-left-up text-success float-end"
                                    ></i
                                  ></small>
                                  <small
                                    ><i
                                      v-if="
                                        isActiveSub ==
                                          l.replace(/[\s-&,]+/g, '-') &&
                                        l != 'tempKeyName'
                                      "
                                      class="icofont icofont-rounded-left-down text-success float-end"
                                    ></i
                                  ></small>
                                  <!--                                </div>-->
                                  <transition>
                                    <div
                                      v-show="
                                        isActiveSub ===
                                        l.replace(/[\s-&,]+/g, '-')
                                      "
                                      :id="l.replace(/[\s-&,]+/g, '-')"
                                      :aria-labelledby="
                                        l.replace(/[\s-&]+/g, '-')
                                      "
                                      data-parent=""
                                    >
                                      <div class="checkbox-animated mt-2">
                                        <label
                                          v-if="c.length > 0"
                                          class="d-block"
                                          :for="l.replace(/[\s-&]+/g, '-') + e"
                                        >
                                          <input
                                            :data-main-id="
                                              e.replace(/[\s-&]+/g, '-')
                                            "
                                            class="checkbox_animated select-all"
                                            :id="l.replace(/[\s-&]+/g, '-') + e"
                                            :data-block-id="
                                              l.replace(/[\s-&]+/g, '-')
                                            "
                                            type="checkbox"
                                          /><small class="text-success"
                                            >Select All</small
                                          >
                                        </label>
                                        <div
                                          v-for="(n, m) in c"
                                          class="checkbox-item-container"
                                          :key="m"
                                        >
                                          <label
                                            class="d-block pt-1 pb-1"
                                            :for="
                                              n.checkboxItem.replace(
                                                /[\s-&]+/g,
                                                '-'
                                              )
                                            "
                                          >
                                            <input
                                              :data-main-id="
                                                e.replace(/[\s-&]+/g, '-')
                                              "
                                              :class="
                                                'checkbox_animated single-checkbox ' +
                                                l.replace(/[\s-&]+/g, '-')
                                              "
                                              :data-block-item-id="
                                                l.replace(/[\s-&]+/g, '-')
                                              "
                                              :id="
                                                n.checkboxItem.replace(
                                                  /[\s-&]+/g,
                                                  '-'
                                                )
                                              "
                                              type="checkbox"
                                              :value="n.checkboxItem"
                                            />
                                            <small
                                              class="text-success p-1 rounded"
                                              :data-block-text-id="
                                                l.replace(/[\s-&]+/g, '-')
                                              "
                                              >{{ n.checkboxItem }}</small
                                            >
                                          </label>
                                        </div>
                                      </div>
                                    </div>
                                  </transition>
                                </div>
                              </div>
                            </transition-group>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <button class="btn btn-primary" type="submit">Register</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>
<style scoped>
.high-light-text {
  background-color: #e2c636 !important;
  color: #ffffff !important;
}
</style>
<script>
export default {
  data() {
    return {
      radioOption: null,
      showAnswerInput: false,
      isActiveMain: null,
      isActiveSub: null,
      filters: [
        {
          Flooring: [
            {
              "Plank-flooring": [
                { checkboxItem: "Flooring Installation" },
                { checkboxItem: "Vinyl Plank Flooring Installation" },
                { checkboxItem: "Hardwood Flooring Installation" },
                { checkboxItem: "Laminate Flooring Installation" }
              ],
              Carpet: [
                { checkboxItem: "Carpet Installation" },
                { checkboxItem: "Carpet Removal" }
              ],
              Tile: [{ checkboxItem: "Tile Installation" }],
              Epoxy: [
                { checkboxItem: "Polyaspartic Outdoor Flooring" },
                { checkboxItem: "Garage Epoxy Flooring" }
              ]
            }
          ],
          Asbestos: [
            {
              tempKeyName: [
                { checkboxItem: "Asbestos Testing" },
                { checkboxItem: "Asbestos Removal" },
                { checkboxItem: "Mold Damage Service" }
              ]
            }
          ],
          Kitchen: [
            {
              Cabinets: [
                { checkboxItem: "Kitchen Cabinet Services" },
                { checkboxItem: "Cabinet Makeover" },
                { checkboxItem: "Kitchen Cabinet Installation" },
                { checkboxItem: "Cabinet Hardware Installation" },
                { checkboxItem: "Cabinet Repair" }
              ],
              "Countertops & Tile": [
                { checkboxItem: "Countertop Installation" },
                { checkboxItem: "Backsplash Installation" },
                { checkboxItem: "Tile Installation" }
              ],
              "Kitchen Plumbing": [
                { checkboxItem: "Sink Installation" },
                { checkboxItem: "Sink Repair" },
                { checkboxItem: "Faucet Replacement" },
                { checkboxItem: "Faucet Repair" },
                { checkboxItem: "Garbage Disposal Installation" },
                { checkboxItem: "Water Treatment Services" },
                { checkboxItem: "Water Line Installation" },
                { checkboxItem: "Gas Line Repair" }
              ],
              Organization: [{ checkboxItem: "Pantry Installation" }]
            }
          ],
          "Doors & Windows": [
            {
              Windows: [
                { checkboxItem: "Window Installation" },
                { checkboxItem: "Vinyl Window Replacement" },
                { checkboxItem: "Wood Window Replacement" },
                { checkboxItem: "Impact Window Replacement" },
                { checkboxItem: "Glass Replacement" }
              ],
              "Interior & Exterior Doors": [
                { checkboxItem: "Exterior and Interior Door Installation" },
                { checkboxItem: "Pet Door Installation" },
                { checkboxItem: "Door Jamb Repair" },
                { checkboxItem: "Locksmith" }
              ],
              "Garage Doors": [
                { checkboxItem: "Garage Door & Opener Installation" },
                { checkboxItem: "Garage Door & Opener Repair" }
              ],
              "Doorbells & Door Hardware": [
                { checkboxItem: "Doorbell Installation" },
                { checkboxItem: "Smart Doorbell Installation" },
                { checkboxItem: "Door Hardware Installation" },
                { checkboxItem: "Closet Hardware Installation" }
              ],
              "Interior Window Treatments": [
                { checkboxItem: "Blinds Installation" },
                { checkboxItem: "Kirsch Custom Window Treatments" },
                { checkboxItem: "Plantation Shutter Installation" }
              ],
              "Exterior Window Treatments": [
                { checkboxItem: "Hurricane Shutter Installation" },
                { checkboxItem: "Exterior Shutter Installation" },
                { checkboxItem: "Exterior Shutter Repair" },
                { checkboxItem: "Storm Shutter Repair" },
                { checkboxItem: "Storm Shutter Removal" },
                { checkboxItem: "Window Well Cover Installation" },
                { checkboxItem: "Outdoor Window Shade Installation" },
                { checkboxItem: "Window Security Bar Installation" }
              ],
              Screens: [
                { checkboxItem: "Retractable Screen Installation" },
                { checkboxItem: "Window and Door Screen Repair" }
              ]
            }
          ],
          "Heating & Cooling": [
            {
              "Heating & Cooling Systems": [
                { checkboxItem: "HVAC Services" },
                { checkboxItem: "HVAC Installation & Replacement" },
                { checkboxItem: "HVAC Repair" },
                { checkboxItem: "HVAC Maintenance" },
                { checkboxItem: "Mini Split Installation" },
                { checkboxItem: "Window Mounted AC Installation" },
                { checkboxItem: "Window Mounted AC Repair" },
                { checkboxItem: "Electric Wall Heater Installation" }
              ],
              Thermostats: [
                { checkboxItem: "Thermostat Replacement" },
                { checkboxItem: "Fire Alarm" }
              ],
              "Ducting & Venting": [
                { checkboxItem: "Indoor Air Quality Services" },
                { checkboxItem: "Venting Installation" },
                { checkboxItem: "Gable Vent Installation" },
                { checkboxItem: "Turbine Vent Installation" },
                { checkboxItem: "Exterior Vent Replacement" }
              ],
              Insulation: [
                { checkboxItem: "Attic Insulation Installation" },
                { checkboxItem: "Roof Insulation" },
                { checkboxItem: "Wall Insulation" }
              ],
              "House Fans": [
                { checkboxItem: "Attic Fan Installation" },
                { checkboxItem: "Whole House Fan Installation" },
                { checkboxItem: "Bathroom Fan Installation" },
                { checkboxItem: "Bathroom Fan Repair" },
                { checkboxItem: "Exhaust Fan Installation" },
                { checkboxItem: "Exhaust Fan Repair" },
                { checkboxItem: "Ceiling Fan Installation" },
                { checkboxItem: "Ceiling Fan Repair" }
              ],
              "Gas Services": [
                { checkboxItem: "Gas Line Installation" },
                { checkboxItem: "Gas Line Repair" },
                { checkboxItem: "Gas Fireplace Install/Conversion" }
              ]
            }
          ],
          "Exterior Home": [
            {
              Sheds: [
                { checkboxItem: "Shed Installation" },
                { checkboxItem: "Shed Repair" },
                { checkboxItem: "Shed Assembly" }
              ],
              "Pergolas, Decks & Awnings": [
                { checkboxItem: "4K Pergola Installation" },
                { checkboxItem: "Alumawood Pergola Installation" },
                { checkboxItem: "Vinyl Pergola Installation" },
                { checkboxItem: "Wood Pergola Installation" },
                { checkboxItem: "Deck Building" },
                { checkboxItem: "Deck Repair" },
                { checkboxItem: "Deck Painting" },
                { checkboxItem: "Awning Installation" },
                { checkboxItem: "Awning Repair" }
              ],
              Fences: [
                { checkboxItem: "Fence Installation" },
                { checkboxItem: "Fence Repair" },
                { checkboxItem: "Fence Painting" },
                { checkboxItem: "Gate Repair" }
              ],
              "Generators & Solar Power": [
                { checkboxItem: "Generator Installation" },
                { checkboxItem: "Solar Panel Installation" },
                { checkboxItem: "Solar Pool Heater Installation" },
                { checkboxItem: "Off Grid Solar System Assembly" }
              ],
              "Garage & Carport": [
                { checkboxItem: "Garage Door & Opener Installation" },
                { checkboxItem: "Garage Door & Opener Repair" },
                { checkboxItem: "Garage Storage Installation" },
                { checkboxItem: "Garage Remodel" },
                { checkboxItem: "Carport Assembly" }
              ],
              "Outdoor Living": [
                { checkboxItem: "Artificial Grass Installation" },
                { checkboxItem: "Barbeque Assembly" },
                { checkboxItem: "Patio Furniture Assembly" },
                { checkboxItem: "Fire Pit Installation" },
                { checkboxItem: "Play Set Assembly" }
              ],
              "Patio & Sunroom": [
                { checkboxItem: "Concrete Patio Installation" },
                { checkboxItem: "Concrete Patio Repair" },
                { checkboxItem: "Sunroom Installation" },
                { checkboxItem: "Sunroom Repair" }
              ],
              "Gutters & Roof": [
                { checkboxItem: "Gutter Installation" },
                { checkboxItem: "Gutter Repair" },
                { checkboxItem: "Roof Coating" },
                { checkboxItem: "Gutter Cleaning" }
              ],
              "Outdoor Water Systems": [
                { checkboxItem: "Water Fountain Installation" },
                { checkboxItem: "Water Fountain Maintenance" },
                { checkboxItem: "Pond Installation" }
              ],
              "Sidewalk & Driveway": [
                { checkboxItem: "Driveway Installation" },
                { checkboxItem: "Driveway Resurfacing" },
                { checkboxItem: "Driveway Repair" },
                { checkboxItem: "Sidewalk Installation" },
                { checkboxItem: "Sidewalk Repair" },
                { checkboxItem: "Brick Walkway Installation" },
                { checkboxItem: "Brick Walkway Repair" },
                { checkboxItem: "Concrete Walkway Installation" },
                { checkboxItem: "Concrete Walkway Repair" },
                { checkboxItem: "Gravel or Loose Fill Installation" },
                { checkboxItem: "Paver Installation" },
                { checkboxItem: "Mailbox Installation" }
              ],
              "Chimney & Fireplace": [
                { checkboxItem: "Chimney Cap Installation" },
                { checkboxItem: "Chimney Liner Installation" },
                { checkboxItem: "Chimney Sweep" },
                { checkboxItem: "Gas Fireplace Install/Conversion" }
              ],
              "Pool & Hot Tub": [
                { checkboxItem: "Solar Pool Heater Installation" },
                { checkboxItem: "Pool Enclosure Installation" },
                { checkboxItem: "Pool Enclosure Repair" },
                { checkboxItem: "Hot Tub Installation" },
                { checkboxItem: "Hot Tub Wire Repair" }
              ]
            }
          ],
          "Water Heaters & Treatment": [
            {
              "Water Heaters": [
                { checkboxItem: "Water Heater Installation" },
                { checkboxItem: "Water Heater Repair" },
                { checkboxItem: "Tankless Water Heater Installation" },
                { checkboxItem: "Hybrid Heat Pump Water Heater Installation" }
              ],
              "Water Treatments": [{ checkboxItem: "Water Treatment Services" }]
            }
          ],
          Bathroom: [
            {
              "Bathroom Renovation": [{ checkboxItem: "Bathroom Remodeling" }],
              "Bathtub & Shower": [
                { checkboxItem: "Shower Repair" },
                { checkboxItem: "Custom Shower Door Installation" },
                { checkboxItem: "Stock Shower Door Installation" },
                { checkboxItem: "Shower Head Replacement" },
                { checkboxItem: "Bathtub Installation" },
                { checkboxItem: "Bathtub Repair" },
                { checkboxItem: "Tub to Shower Conversion" },
                { checkboxItem: "Caulking Services" },
                { checkboxItem: "Bathtub & Shower Valve Replacement" },
                { checkboxItem: "Hotmop" }
              ],
              Toilets: [
                { checkboxItem: "Toilet Installation" },
                { checkboxItem: "Toilet Repair" },
                { checkboxItem: "Toilet Seat Installation" }
              ],
              "Facuets & Sinks": [
                { checkboxItem: "Sink Installation" },
                { checkboxItem: "Sink Repair" },
                { checkboxItem: "Faucet Replacement" },
                { checkboxItem: "Faucet Repair" },
                { checkboxItem: "Bathroom Vanity Installation" }
              ],
              Accessibility: [
                { checkboxItem: "Walk-In Tub Installation" },
                { checkboxItem: "CleanCut Tub Installation" },
                { checkboxItem: "Grab Bar Installation" }
              ],
              "Backsplash & Tile": [
                { checkboxItem: "Tile Installation" },
                { checkboxItem: "Backsplash Installation" }
              ],
              "Bathroom Fans": [
                { checkboxItem: "Exhaust Fan Installation" },
                { checkboxItem: "Exhaust Fan Repair" },
                { checkboxItem: "Bathroom Fan Installation" },
                { checkboxItem: "Bathroom Fan Repair" }
              ]
            }
          ],
          "Home Organization": [
            {
              "Storage & Organization": [
                { checkboxItem: "Home Organization Services" },
                { checkboxItem: "Closet Installation" },
                { checkboxItem: "Garage Storage Installation" },
                { checkboxItem: "Pantry Installation" },
                { checkboxItem: "Home Office Installation" },
                { checkboxItem: "Laundry Room Installation" },
                { checkboxItem: "Mudroom Installation" }
              ]
            }
          ],
          "Electrical & Lighting": [
            {
              "Interior Lighting": [
                { checkboxItem: "Light Fixture Installation" },
                { checkboxItem: "Light Fixture Repair" },
                { checkboxItem: "Chandelier Installation" },
                { checkboxItem: "Chandelier Repair" },
                { checkboxItem: "Interior Ceiling Lighting Installation" },
                { checkboxItem: "Interior Ceiling Lighting Repair" },
                { checkboxItem: "Recessed Lighting Installation" },
                { checkboxItem: "Light Fixture Replacement" },
                { checkboxItem: "Recessed Lighting Repair" },
                { checkboxItem: "Interior LED Lighting Installation" },
                { checkboxItem: "LED Interior Light Conversion" },
                { checkboxItem: "Interior Wall Lighting Installation" },
                { checkboxItem: "Interior Wall Lighting Repair" },
                { checkboxItem: "Pendant Installation" },
                { checkboxItem: "Pendant Repair" },
                { checkboxItem: "Track Lighting Installation" },
                { checkboxItem: "Track Lighting Repair" },
                { checkboxItem: "Fluorescent Lighting Installation" },
                { checkboxItem: "Fluorescent Lighting Repair" },
                { checkboxItem: "Under Cabinet Lighting Installation" }
              ],
              "Ceiling Fans": [
                { checkboxItem: "Ceiling Fan Installation" },
                { checkboxItem: "Ceiling Fan Repair" }
              ],
              "Exterior Lighting": [
                { checkboxItem: "Exterior Lighting Installation" },
                { checkboxItem: "Security Lighting Installation" },
                { checkboxItem: "Landscape Lighting Installation" },
                { checkboxItem: "Exterior Wall Lighting Installation" },
                { checkboxItem: "Exterior LED Lighting Installation" },
                { checkboxItem: "Exterior Hanging Light Replacement" },
                { checkboxItem: "Flood Lighting Installation" },
                { checkboxItem: "Holiday Lighting Installation" },
                { checkboxItem: "Christmas Lighting Repair" }
              ],
              "Generators & Solar Power": [
                { checkboxItem: "Generator Installation" },
                { checkboxItem: "Solar Pool Heater Installation" },
                { checkboxItem: "Solar Panel Installation" },
                { checkboxItem: "Off Grid Solar System Assembly" }
              ],
              "Electrical & Wiring": [
                { checkboxItem: "Electrical Panel Installation" },
                { checkboxItem: "Electrical Panel Upgrade" },
                { checkboxItem: "Electrical Panel Repair" },
                { checkboxItem: "Electrical Wiring Installation" },
                { checkboxItem: "Electrical Wiring Upgrade" },
                { checkboxItem: "Outlet Installation" },
                { checkboxItem: "Outlet Repair" },
                { checkboxItem: "Meter Socket Installation" },
                { checkboxItem: "Light Switch Installation" },
                { checkboxItem: "Smart Light Switch Installation" },
                { checkboxItem: "Smart Dimmer Installation" },
                { checkboxItem: "Electronic Setup Services" },
                { checkboxItem: "Low Voltage" }
              ],
              "House Fans": [
                { checkboxItem: "Exhaust Fan Installation" },
                { checkboxItem: "Exhaust Fan Repair" },
                { checkboxItem: "Bathroom Fan Installation" },
                { checkboxItem: "Bathroom Fan Repair" },
                { checkboxItem: "Attic Fan Installation" },
                { checkboxItem: "Whole House Fan Installation" }
              ],
              "Safety & Security": [
                { checkboxItem: "Smoke Alarm Installation" },
                { checkboxItem: "Smoke Alarm Repair" },
                { checkboxItem: "Cameras / CCTV" }
              ]
            }
          ]
        }
      ]
    };
  },
  methods: {
    toggleFilterMain(key) {
      if (key == "Asbestos") {
        this.isActiveSub = "tempKeyName";
      }
      this.isActiveMain = this.isActiveMain === key ? null : key;
    },
    toggleFilterSub(key) {
      this.isActiveSub = this.isActiveSub === key ? null : key;
    }
  },
  // watch: {
  //   radioOption(n, o) {
  //     console.log(n);
  //     if (n == "yes") {
  //       this.showAnswerInput = true;
  //     } else {
  //       this.showAnswerInput = false;
  //     }
  //   }
  // },
  mounted() {
    $(document).on("change", ".single-checkbox", function () {
      let classId = $(this).attr("data-block-item-id");
      let holderId = $(this).attr("data-main-id");
      $("#" + classId + holderId).prop("checked", false);
      let parentId = $(this).parent().parent().parent().parent().attr("id");
      let checkedCounter = 0;

      $(".single-checkbox").each(function () {
        if (this.checked) {
          checkedCounter++;
        }
      });

      let checkBox = $(this).attr("data-main-id");
      if (this.checked) {
        $(this).siblings().addClass("high-light-text");
        $(".filters")
          .find("." + checkBox)
          .addClass("high-light-text p-1");
        $(this)
          .parent()
          .parent()
          .parent()
          .parent()
          .parent()
          .find("button")
          .children()
          .addClass("high-light-text p-1");
      } else {
        $(this).siblings().removeClass("high-light-text");
        if (checkedCounter == 0) {
          $("#" + classId + holderId).prop("checked", false);
          $(this)
            .parent()
            .parent()
            .parent()
            .parent()
            .parent()
            .find("button")
            .children()
            .removeClass("high-light-text p-1");
          $(".filters")
            .find("." + checkBox)
            .removeClass("high-light-text p-1");
        }
      }
    });

    $(document).on("change", ".select-all", function () {
      let parentId = $(this).parent().parent().parent().parent().attr("id");
      let checkBox = $(this).attr("data-main-id");
      let checkedCounter = 0;

      $(".select-all").each(function () {
        if ($(this).is(":checked")) {
          checkedCounter++;
        }
      });

      if (this.checked) {
        $(".filters")
          .find("." + checkBox)
          .addClass("high-light-text p-1");
        $(this)
          .parent()
          .parent()
          .parent()
          .parent()
          .parent()
          .find("button")
          .children()
          .addClass("high-light-text p-1");
        $("." + $(this).attr("data-block-id")).each(function () {
          this.checked = true;
          $(this).siblings().addClass("high-light-text");
        });
      } else {
        if (checkedCounter == 0) {
          $(".filters")
            .find("." + checkBox)
            .removeClass("high-light-text p-1");
        }
        $(this)
          .parent()
          .parent()
          .parent()
          .parent()
          .parent()
          .find("button")
          .children()
          .removeClass("high-light-text p-1");
        $("." + $(this).attr("data-block-id")).each(function () {
          this.checked = false;
          $(this).siblings().removeClass("high-light-text");
        });
      }
    });
  }
};
</script>
