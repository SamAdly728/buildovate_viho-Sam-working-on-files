import { usePage } from "@inertiajs/vue3";
import axios from "axios";
import _ from "lodash";
const page = usePage();

export const fetchJobsites = async (search) => {
  const response = await axios.get("/api/jobsites", {
    params: {
      search: search
    }, // Pass the page as a query parameter
    headers: {
      Authorization: "Bearer " + page.props.csrf_token,
      Accept: "application/json",
      "X-Requested-With": "XMLHttpRequest"
    }
  });
  return response.data;
};

export const fetchLeads = async (pageNum, search) => {
  const response = await axios.get("/api/leads", {
    params: {
      page: pageNum,
      limit: 25,
      search: search
    },
    headers: {
      Authorization: "Bearer " + page.props.csrf_token,
      Accept: "application/json",
      "X-Requested-With": "XMLHttpRequest"
    }
  });
  return response.data;
};

export const fetchTodo = async (entityId = null, entityType = null) => {
  const response = await axios.get("/api/todo", {
    params: {
      entityId: entityId,
      entityType: entityType
    },
    headers: {
      Authorization: "Bearer " + page.props.csrf_token,
      Accept: "application/json",
      "X-Requested-With": "XMLHttpRequest"
    }
  });
  return response.data;
};

export const addTodoRecord = async (payload) => {
  const response = await axios.post("/api/todo", payload, {
    headers: {
      Authorization: "Bearer " + page.props.csrf_token,
      Accept: "application/json",
      "X-Requested-With": "XMLHttpRequest"
    }
  });
  return response.data;
};

export const updateTodoRecord = async (id, payload) => {
  const response = await axios.put(`/api/todo/${id}`, payload, {
    headers: {
      Authorization: "Bearer " + page.props.csrf_token,
      Accept: "application/json",
      "X-Requested-With": "XMLHttpRequest"
    }
  });
  return response.data;
};

export const markTodo = async (id, is_completed) => {
  const response = await axios.put(
    `/api/todo/mark/${id}`,
    { is_completed: is_completed },
    {
      headers: {
        Authorization: "Bearer " + page.props.csrf_token,
        Accept: "application/json",
        "X-Requested-With": "XMLHttpRequest"
      }
    }
  );
  return response.data;
};

export const removeTodo = async (id) => {
  const response = await axios.delete(
    `/api/todo/${id}`,
    {},
    {
      headers: {
        Authorization: "Bearer " + page.props.csrf_token,
        Accept: "application/json",
        "X-Requested-With": "XMLHttpRequest"
      }
    }
  );
  return response.data;
};

export const fetchJobsiteRecord = async (jobsite_id) => {
  const response = await axios.get("/api/jobsites", {
    params: {
      jobsite_id: jobsite_id
    },
    headers: {
      Authorization: "Bearer " + page.props.csrf_token,
      Accept: "application/json",
      "X-Requested-With": "XMLHttpRequest"
    }
  });
  return response.data;
};

export const fetchLeadRecord = async (lead_id) => {
  const response = await axios.get("/api/leads", {
    params: {
      lead_id: lead_id
    },
    headers: {
      Authorization: "Bearer " + page.props.csrf_token,
      Accept: "application/json",
      "X-Requested-With": "XMLHttpRequest"
    }
  });
  return response.data;
};

export const processBecomeAPro = async (payload) => {
  const response = await axios.post("/api/pro_users", payload, {
    headers: {
      Authorization: "Bearer " + page.props.csrf_token,
      Accept: "application/json",
      "X-Requested-With": "XMLHttpRequest"
    }
  });
  return response.data;
};

export function formatDate(dateString) {
  const options = { year: "numeric", month: "long", day: "numeric" };
  const date = new Date(dateString);
  return date.toLocaleDateString("en-US", options);
}

export const getPros = async (obj) => {
  const q = _.map(obj, (value, key) => `${key}=${value}`).join("&");

  const response = await axios.get(`/api/pro_users?${q}`, {
    headers: {
      Authorization: "Bearer " + page.props.csrf_token,
      Accept: "application/json",
      "X-Requested-With": "XMLHttpRequest"
    }
  });
  return response.data;
};
