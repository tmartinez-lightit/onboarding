import React from "react";
import { Route } from "react-router-dom";

import { RouterWrapper, ROUTES } from "~/router";
import { Airlines, Cities, NotFound } from "~/screens";
import { AirlineDetail } from "~/screens/Airlines/AirlineDetail";

export const SystemRouter = () => {
  return (
    <RouterWrapper>
      <Route element={<Cities />} path={ROUTES.cities} />
      <Route element={<Airlines />} path={ROUTES.airlines.base} />
      <Route element={<AirlineDetail />} path={ROUTES.airlines.detail} />
      <Route element={<NotFound />} path="*" />
    </RouterWrapper>
  );
};
