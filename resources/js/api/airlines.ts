import type { ServiceResponse } from "./api.types";
import { api } from "./axios";
import { City } from "./cities";

const DOMAIN = "airline";
const ALL = "all";

export interface Airline {
  id: number;
  name: string;
  description: string;
  activeFlightsCount: number;
}

export interface AirlineWithCities extends Airline {
  cities: City[];
}

export const WITH_PARAMS = {
  cities: "cities",
};

export type WithParams = (typeof WITH_PARAMS)[keyof typeof WITH_PARAMS];

export const ALL_WITH_PARAMS = Object.values(WITH_PARAMS);

export const getAirlinesQuery = (page: string, withParams?: WithParams[]) => {
  return {
    queryKey: [DOMAIN, ALL, "getAirlinesQuery", page, withParams] as const,
    queryFn: async () => {
      const response = await api.get<ServiceResponse<Airline[]>>(
        `/airlines?page=${page}${withParams ? `&with=${withParams.join(",")}` : ""}`,
      );
      return response.data;
    },
  };
};

export const getAirlineDetailQuery = (id: string) => {
  return {
    queryKey: [DOMAIN, id, "getAirlineDetailQuery"] as const,
    queryFn: async () => {
      const response = await api.get<ServiceResponse<AirlineWithCities>>(
        `/airlines/${id}?with=${ALL_WITH_PARAMS.join(",")}`,
      );
      return response.data;
    },
  };
};

export const toggleAirlineCityQuery = {
  mutation: async (airlineId: string, cityIds: string[]) => {
    const response = await api.post(`/airlines/${airlineId}/cities/toggle`, {
      cityIds,
    });
    return response.data;
  },
};
