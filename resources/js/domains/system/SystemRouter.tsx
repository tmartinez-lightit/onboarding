import React from "react";
import { Route } from "react-router-dom";

import { RouterWrapper, ROUTES } from "~/router";
import { Cities, NotFound } from "~/screens";

export const SystemRouter = () => {
  return (
    <RouterWrapper>
      <Route element={<Cities />} path={ROUTES.cities} />
      <Route element={<NotFound />} path="*" />
    </RouterWrapper>
  );
};
