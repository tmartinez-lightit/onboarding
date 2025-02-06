import { useQuery } from "@tanstack/react-query";
import { useParams } from "react-router-dom";

import { getAirlineDetailQuery } from "../../api/airlines";
import AirlineOperations from "./components/AirlineOperations";

export const AirlineDetail = () => {
  const { id } = useParams();

  if (!id) {
    return (
      <div className="flex h-screen items-center justify-center">
        <div className="text-xl text-gray-600">Airline not found</div>
      </div>
    );
  }

  const { data, isLoading, isError } = useQuery(getAirlineDetailQuery(id));

  if (isLoading) {
    return (
      <div className="flex h-screen items-center justify-center">
        <div className="text-xl text-gray-600">Loading...</div>
      </div>
    );
  }

  if (isError) {
    return (
      <div className="flex h-screen items-center justify-center">
        <div className="text-xl text-red-600">
          Error loading airline details
        </div>
      </div>
    );
  }

  if (!data) {
    return (
      <div className="flex h-screen items-center justify-center">
        <div className="text-xl text-gray-600">Airline not found</div>
      </div>
    );
  }

  const { name, description, activeFlightsCount, cities } = data.data;

  return (
    <div className="mx-auto max-w-4xl px-4 py-8">
      <div className="rounded-lg bg-white p-6 shadow-lg">
        <div className="mb-6 border-b pb-4">
          <h1 className="text-3xl font-bold text-gray-800">{name}</h1>
        </div>

        <div className="space-y-6">
          <div>
            <h2 className="mb-2 text-xl font-semibold text-gray-700">About</h2>
            <p className="text-gray-600">{description}</p>
          </div>

          <div>
            <h2 className="mb-2 text-xl font-semibold text-gray-700">
              Statistics
            </h2>
            <div className="rounded-md bg-gray-50 p-4">
              <div className="flex items-center">
                <span className="text-gray-600">Active Flights:</span>
                <span className="ml-2 font-semibold text-blue-600">
                  {activeFlightsCount}
                </span>
              </div>
            </div>
          </div>

          <div>
            <AirlineOperations airline={data.data} />
            <h2 className="mb-2 text-xl font-semibold text-gray-700">
              Destinations
            </h2>
            <div className="grid grid-cols-2 gap-4 md:grid-cols-3">
              {cities.map((city) => (
                <div key={city.id} className="rounded-md bg-gray-50 p-4">
                  <div className="font-medium text-gray-800">{city.name}</div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};
