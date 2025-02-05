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

export interface AirlineWithFlights extends Airline {
  activeFlightsCount: number;
  cities: City[];
}

export const WITH_PARAMS = {
  cities: "cities",
  flights: "flights",
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
      const response = await api.get<ServiceResponse<AirlineWithFlights>>(
        `/airlines/${id}?with=${ALL_WITH_PARAMS.join(",")}`,
      );
      return response.data;
    },
  };
};

export const addCitiesToAirlineQuery = (
  airlineId: string,
  cities: string[],
) => {
  return {
    mutation: async () => {
      const response = await api.post(`/airlines/${airlineId}/cities`, {
        cities,
      });
      return response.data;
    },
  };
};

export const removeCitiesFromAirlineQuery = (
  airlineId: string,
  cities: string[],
) => {
  return {
    mutation: async () => {
      const response = await api.delete(`/airlines/${airlineId}/cities`, {
        data: { cities },
      });
      return response.data;
    },
  };
};
