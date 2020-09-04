const baseDomain = process.env.MIX_APP_URL;
const subDelirectory = "logi_improve";
const baseURL = `${baseDomain}/${subDelirectory}`;
const apiBaseURL = `${baseDomain}/${subDelirectory}/api`;

export const BASE_URL = baseURL;
export const API_BASE_URL = apiBaseURL;
