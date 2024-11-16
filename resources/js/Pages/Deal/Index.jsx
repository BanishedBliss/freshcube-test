import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.jsx";
import {Head} from "@inertiajs/react";

export default function Index({auth, deals}) {
  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <h2 className="font-semibold text-xl text-gray-800
        dark:text-gray-200 leading-tight">
          Выбор сделки
        </h2>
      }
    >
      <Head title="Выбор сделки"/>

      <div className="py-12">
        <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
            <div className="p-6 text-gray-900 dark:text-gray-100">
              Выбор сделки
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  )
}
