import type { ServiceResponse } from "./api.types";
import { api } from "./axios";
import { UpsertCityPayloadSchema } from "./schemas";

const DOMAIN = "city";
const ALL = "all";

export interface City {
  id: number;
  name: string;
}

export const getCitiesQuery = (page: string) => ({
  queryKey: [DOMAIN, ALL, "getCitiesQuery", page],
  queryFn: async () => {
    const response = await api.get<ServiceResponse<City[]>>(
      `/cities?page=${page}`,
    );

    return response.data;
  },
});

export const createCityQuery = {
  mutation: async (data: UpsertCityPayloadSchema) => {
    const response = await api.post<ServiceResponse<City>>(`/cities`, data);
    return response.data;
  },
};

export const updateCityQuery = {
  mutation: async (id: number, data: UpsertCityPayloadSchema) => {
    const response = await api.put<ServiceResponse<City>>(
      `/cities/${id}`,
      data,
    );
    return response.data;
  },
};

export const deleteCityQuery = {
  mutation: async (id: number) => {
    const response = await api.delete<ServiceResponse<City>>(`/cities/${id}`);
    return response.data;
  },
};
