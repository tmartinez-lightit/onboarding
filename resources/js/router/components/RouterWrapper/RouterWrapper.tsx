import type { PropsWithChildren } from "react";
import React from "react";
import { Route, Routes } from "react-router-dom";

import { MainLayout } from "~/router";

export const RouterWrapper = ({ children }: PropsWithChildren) => {
  return (
    <Routes>
      <Route element={<MainLayout />}>{children}</Route>
    </Routes>
  );
};
