import { Outlet } from "react-router-dom";

export const Layout = () => {
  return (
    <div className="h-screen flex-col overflow-hidden bg-gray-900 md:flex md:flex-row">
      <main className="h-full grow overflow-y-auto">
        <Outlet />
      </main>
    </div>
  );
};
